<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOnboardingAgreementRequest;
use App\Services\DueDiligenceService;
use App\Services\PartnerAgreementService;
use App\Support\BrandContact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class OnboardingAgreementController extends Controller
{
    public function createPublisher(
        DueDiligenceService $dueDiligence,
        PartnerAgreementService $agreements,
    ): View|RedirectResponse {
        return $this->create('publisher', $dueDiligence, $agreements);
    }

    public function createAdvertiser(
        DueDiligenceService $dueDiligence,
        PartnerAgreementService $agreements,
    ): View|RedirectResponse {
        return $this->create('advertiser', $dueDiligence, $agreements);
    }

    public function storePublisher(
        StoreOnboardingAgreementRequest $request,
        DueDiligenceService $dueDiligence,
        PartnerAgreementService $agreements,
    ): RedirectResponse {
        return $this->store($request, 'publisher', $dueDiligence, $agreements);
    }

    public function storeAdvertiser(
        StoreOnboardingAgreementRequest $request,
        DueDiligenceService $dueDiligence,
        PartnerAgreementService $agreements,
    ): RedirectResponse {
        return $this->store($request, 'advertiser', $dueDiligence, $agreements);
    }

    public function success(): View|RedirectResponse
    {
        if (! session()->has('onboarding_agreement_reference')) {
            return redirect()->route('apply');
        }

        return view('pages.onboarding.agreement-success', [
            'type' => session('onboarding_agreement_type'),
            'email' => session('onboarding_agreement_email'),
            'reference' => session('onboarding_agreement_reference'),
        ]);
    }

    protected function create(
        string $type,
        DueDiligenceService $dueDiligence,
        PartnerAgreementService $agreements,
    ): View|RedirectResponse {
        $email = request('email');
        $reference = request('ref');

        if (! is_string($email) || ! filled($email)) {
            return redirect()
                ->route($type === 'advertiser' ? 'onboarding.advertiser' : 'onboarding.publisher')
                ->with('error', 'Enter your email on the questionnaire first, or use the link from your application email.');
        }

        $review = $dueDiligence->findReviewForQuestionnaire(
            $type,
            is_string($reference) ? $reference : null,
            $email,
        );

        if (! $review) {
            return redirect()
                ->route('apply')
                ->with('error', 'We could not find your application. Apply first or check your reference.');
        }

        if ($agreements->alreadySigned($review)) {
            return redirect()
                ->route('onboarding.agreement.success')
                ->with('onboarding_agreement_type', $type)
                ->with('onboarding_agreement_email', $email)
                ->with('onboarding_agreement_reference', $review->partner_reference);
        }

        if (! $agreements->questionnaireCompleted($review)) {
            $questionnaireRoute = $type === 'advertiser' ? 'onboarding.advertiser' : 'onboarding.publisher';

            return redirect()
                ->route($questionnaireRoute, ['email' => $email, 'ref' => $review->partner_reference])
                ->with('error', 'Complete the onboarding questionnaire before signing your agreement.');
        }

        $questionnaire = $agreements->questionnaireResponses($review);

        return view('pages.onboarding.agreement', [
            'type' => $type,
            'review' => $review,
            'questionnaire' => $questionnaire,
            'agreementId' => $agreements->agreementId($review),
            'agreementBody' => $agreements->renderAgreementBody($review, $questionnaire),
            'agreementRoute' => $type === 'advertiser'
                ? 'onboarding.advertiser.agreement.store'
                : 'onboarding.publisher.agreement.store',
            'fullAgreementRoute' => $type === 'advertiser'
                ? 'advertiser-agreement'
                : 'affiliate-agreement',
        ]);
    }

    protected function store(
        StoreOnboardingAgreementRequest $request,
        string $type,
        DueDiligenceService $dueDiligence,
        PartnerAgreementService $agreements,
    ): RedirectResponse {
        $payload = $request->validated();

        $review = $dueDiligence->findReviewForQuestionnaire(
            $type,
            (string) $payload['partner_reference'],
            (string) $payload['contact_email'],
        );

        if (! $review) {
            return back()
                ->withInput()
                ->with('error', 'We could not find your application. Please use the link from your application email.');
        }

        try {
            $agreements->submit(
                $review,
                $payload,
                $request->ip() ?? '127.0.0.1',
                $request->userAgent(),
            );
        } catch (\Throwable $e) {
            Log::error('Onboarding agreement submission failed', [
                'type' => $type,
                'reference' => $payload['partner_reference'] ?? null,
                'email' => $payload['contact_email'] ?? null,
                'message' => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->with('error', $e->getMessage() ?: 'We could not save your agreement. Please try again or email '.BrandContact::email().'.');
        }

        return redirect()
            ->route('onboarding.agreement.success')
            ->with('success', 'Your agreement has been submitted for ConvertLane approval.')
            ->with('onboarding_agreement_type', $type)
            ->with('onboarding_agreement_email', $payload['contact_email'])
            ->with('onboarding_agreement_reference', $review->partner_reference);
    }
}
