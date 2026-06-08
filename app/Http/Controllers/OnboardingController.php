<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOnboardingQuestionnaireRequest;
use App\Mail\OnboardingQuestionnaireMail;
use App\Support\BrandContact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class OnboardingController extends Controller
{
    public function createPublisher(): View
    {
        return $this->create('publisher');
    }

    public function createAdvertiser(): View
    {
        return $this->create('advertiser');
    }

    public function storePublisher(StoreOnboardingQuestionnaireRequest $request): RedirectResponse
    {
        return $this->store($request, 'publisher');
    }

    public function storeAdvertiser(StoreOnboardingQuestionnaireRequest $request): RedirectResponse
    {
        return $this->store($request, 'advertiser');
    }

    protected function create(string $type): View
    {
        return view($type === 'advertiser' ? 'pages.onboarding.advertiser' : 'pages.onboarding.publisher', [
            'type' => $type,
            'email' => request('email'),
            'reference' => request('ref'),
        ]);
    }

    protected function store(StoreOnboardingQuestionnaireRequest $request, string $type): RedirectResponse
    {
        $payload = $request->validated();
        $payload['type'] = $type;

        try {
            $mail = (new OnboardingQuestionnaireMail($payload))
                ->replyTo((string) $payload['contact_email']);

            Mail::to('partners@convertlane.co.uk')->send($mail);
        } catch (\Throwable $e) {
            Log::error('Onboarding questionnaire submission failed', [
                'type' => $type,
                'email' => $payload['contact_email'] ?? null,
                'reference' => $payload['partner_reference'] ?? null,
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);

            return back()
                ->withInput()
                ->with('error', 'We could not submit your questionnaire right now. Please try again or email '.BrandContact::email().'.');
        }

        $route = $type === 'advertiser' ? 'onboarding.advertiser' : 'onboarding.publisher';

        return redirect()
            ->route($route, ['email' => $payload['contact_email'], 'ref' => $payload['partner_reference'] ?? null])
            ->with('success', 'Thanks — your onboarding questionnaire has been submitted. We’ll review it and follow up with the due diligence document request.');
    }
}

