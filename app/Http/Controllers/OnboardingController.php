<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOnboardingQuestionnaireRequest;
use App\Mail\OnboardingQuestionnaireMail;
use App\Services\OnboardingQuestionnaireService;
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

    protected function create(string $type): View
    {
        return view($type === 'advertiser' ? 'pages.onboarding.advertiser' : 'pages.onboarding.publisher', [
            'type' => $type,
            'email' => request('email'),
            'reference' => request('ref'),
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

        if (! $persisted && ! $mailed) {
            return back()
                ->withInput()
                ->with('error', 'We could not submit your questionnaire right now. Please try again or email '.BrandContact::email().'.');
        }

        $route = $type === 'advertiser' ? 'onboarding.advertiser' : 'onboarding.publisher';

        return redirect()
            ->route($route, ['email' => $payload['contact_email'], 'ref' => $payload['partner_reference'] ?? null])
            ->with('success', 'Thanks — your onboarding questionnaire has been submitted. We’ll review it and follow up with the due diligence document request.');
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
}

