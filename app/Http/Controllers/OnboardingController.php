<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOnboardingQuestionnaireRequest;
use App\Mail\OnboardingQuestionnaireMail;
use App\Services\OnboardingQuestionnaireService;
use App\Services\PartnerAgreementService;
use App\Support\BrandContact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class OnboardingController extends Controller
{
    public function createPublisher(): View|RedirectResponse
    {
        return $this->create('publisher');
    }

    public function createAdvertiser(): View|RedirectResponse
    {
        return $this->create('advertiser');
    }

    public function storePublisher(
        StoreOnboardingQuestionnaireRequest $request,
        OnboardingQuestionnaireService $questionnaires,
    ): RedirectResponse {
        return $this->store($request, 'publisher', $questionnaires);
    }

    public function storeAdvertiser(
        StoreOnboardingQuestionnaireRequest $request,
        OnboardingQuestionnaireService $questionnaires,
    ): RedirectResponse {
        return $this->store($request, 'advertiser', $questionnaires);
    }

    protected function create(string $type, ?OnboardingQuestionnaireService $questionnaires = null): View|RedirectResponse
    {
        $email = request('email');
        $reference = request('ref');
        $questionnaires ??= app(OnboardingQuestionnaireService::class);
        $agreements = app(PartnerAgreementService::class);
        $dueDiligence = app(\App\Services\DueDiligenceService::class);

        $prefill = $questionnaires->prefill($type, is_string($reference) ? $reference : null, is_string($email) ? $email : null);
        $questionnaireComplete = false;

        if (is_string($email) && filled($email)) {
            $review = $dueDiligence->findReviewForQuestionnaire(
                $type,
                is_string($reference) ? $reference : null,
                $email,
            );

            if ($review && $agreements->alreadySigned($review)) {
                return redirect()
                    ->route('onboarding.agreement.success')
                    ->with('onboarding_agreement_type', $type)
                    ->with('onboarding_agreement_email', $email)
                    ->with('onboarding_agreement_reference', $review->partner_reference);
            }

            $questionnaireComplete = $review && $agreements->questionnaireCompleted($review);
        }

        return view($type === 'advertiser' ? 'pages.onboarding.advertiser' : 'pages.onboarding.publisher', [
            'type' => $type,
            'prefill' => $prefill,
            'questionnaireComplete' => $questionnaireComplete,
        ]);
    }

    protected function store(
        StoreOnboardingQuestionnaireRequest $request,
        string $type,
        OnboardingQuestionnaireService $questionnaires,
    ): RedirectResponse {
        $payload = $request->validated();
        $payload['type'] = $type;

        $persisted = false;

        try {
            $persisted = $questionnaires->persistOrLog($type, $payload);
        } catch (\Throwable $e) {
            Log::error('Onboarding questionnaire persistence failed', [
                'type' => $type,
                'email' => $payload['contact_email'] ?? null,
                'reference' => $payload['partner_reference'] ?? null,
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);
        }

        $mailed = $this->sendQuestionnaireMail($payload);

        $route = $type === 'advertiser' ? 'onboarding.advertiser' : 'onboarding.publisher';

        if (! $persisted && ! $mailed) {
            return redirect()
                ->route($route, $this->onboardingQueryParams($payload))
                ->withInput()
                ->with('error', 'We could not submit your questionnaire right now. Please try again or email '.BrandContact::email().'.');
        }

        $agreementRoute = $type === 'advertiser'
            ? 'onboarding.advertiser.agreement'
            : 'onboarding.publisher.agreement';

        return redirect()
            ->route($agreementRoute, [
                'email' => $payload['contact_email'],
                'ref' => $payload['partner_reference'] ?? null,
            ])
            ->with('success', 'Questionnaire saved. Review your agreement below and sign to submit for approval.');
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    protected function sendQuestionnaireMail(array $payload): bool
    {
        try {
            $mail = (new OnboardingQuestionnaireMail($payload))
                ->replyTo((string) $payload['contact_email']);

            Mail::to('partners@convertlane.co.uk')->send($mail);

            return true;
        } catch (\Throwable $e) {
            Log::warning('Onboarding questionnaire email failed', [
                'type' => $payload['type'] ?? null,
                'email' => $payload['contact_email'] ?? null,
                'reference' => $payload['partner_reference'] ?? null,
                'message' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * @param  array<string, mixed>  $payload
     * @return array<string, string>
     */
    protected function onboardingQueryParams(array $payload): array
    {
        return array_filter([
            'email' => (string) ($payload['contact_email'] ?? ''),
            'ref' => filled($payload['partner_reference'] ?? null)
                ? (string) $payload['partner_reference']
                : null,
        ], fn ($value) => filled($value));
    }
}

