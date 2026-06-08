<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationRequest;
use App\Mail\OnboardingStartMail;
use App\Models\Application;
use App\Services\DueDiligenceService;
use App\Services\Offer18PartnerService;
use App\Support\BrandContact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function create(): View
    {
        return view('pages.apply');
    }

    public function success(): View|RedirectResponse
    {
        if (! session()->has('apply_reference')) {
            return redirect()->route('apply');
        }

        return view('pages.apply-success', [
            'type' => session('apply_type'),
            'email' => session('apply_email'),
            'reference' => session('apply_reference'),
            'offer18Status' => session('apply_offer18_status'),
        ]);
    }

    public function store(
        StoreApplicationRequest $request,
        DueDiligenceService $dueDiligence,
        Offer18PartnerService $offer18,
    ): RedirectResponse {
        try {
            $data = $request->validated();
            unset($data['terms']);

            $application = Application::create($data);
            $review = $dueDiligence->openReview($application);

            $offer18Result = $offer18->createFromApplication(
                $application,
                $request->ip() ?? '127.0.0.1',
            );

            $this->recordOffer18Sync($application, $offer18Result);

            $this->sendOnboardingStartEmail($application->type, $application->email, $review->partner_reference);

            $message = "Application received (ref: {$review->partner_reference}). You will receive a document request within 2 business days.";

            if ($offer18Result['success']) {
                $message .= ' Your platform account has been created with pending approval — panel login is enabled after due diligence is complete.';
            } elseif ($offer18Result['reason'] === 'already_exists') {
                $message .= ' We found an existing platform account for this email; our team will link it during review.';
            } else {
                $message .= ' Panel access is only granted after full due diligence approval.';
            }

            return redirect()
                ->route('apply.success')
                ->with('success', $message)
                ->with('apply_type', $application->type)
                ->with('apply_email', $application->email)
                ->with('apply_reference', $review->partner_reference)
                ->with('apply_offer18_status', $offer18Result['success'] ? 'created_pending' : ($offer18Result['reason'] ?? ''));
        } catch (\Throwable $e) {
            Log::error('Application submission failed', [
                'email' => $request->input('email'),
                'type' => $request->input('type'),
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);

            return back()
                ->withInput()
                ->with('error', 'We could not submit your application right now. Please try again or email '.BrandContact::email().'.');
        }
    }

    protected function sendOnboardingStartEmail(string $type, string $email, string $reference): void
    {
        $routeName = $type === 'advertiser' ? 'onboarding.advertiser' : 'onboarding.publisher';
        $questionnaireUrl = BrandContact::route($routeName, [
            'email' => $email,
            'ref' => $reference,
        ]);

        try {
            Mail::to($email)->send(new OnboardingStartMail($type, $reference, $questionnaireUrl));
        } catch (\Throwable $e) {
            Log::warning('Failed to send onboarding start email', [
                'type' => $type,
                'email' => $email,
                'reference' => $reference,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * @param  array{success: bool, partner_id: ?string, reason: ?string}  $result
     */
    protected function recordOffer18Sync(Application $application, array $result): void
    {
        $partnerType = $application->type === 'advertiser' ? 'advertiser' : 'affiliate';

        if ($result['success']) {
            $application->update([
                'offer18_partner_id' => $result['partner_id'],
                'offer18_partner_type' => $partnerType,
                'offer18_sync_status' => 'created_pending',
            ]);

            return;
        }

        $status = match ($result['reason']) {
            'already_exists' => 'skipped_exists',
            'not_configured' => 'skipped_not_configured',
            default => 'failed',
        };

        $application->update([
            'offer18_partner_type' => $partnerType,
            'offer18_sync_status' => $status,
        ]);
    }
}
