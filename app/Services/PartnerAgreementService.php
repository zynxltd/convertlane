<?php

namespace App\Services;

use App\Mail\OnboardingAgreementCopyMail;
use App\Models\DueDiligenceReview;
use App\Models\PartnerAgreement;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class PartnerAgreementService
{
    public function __construct(
        protected DueDiligenceService $dueDiligence,
    ) {}

    public function questionnaireCompleted(DueDiligenceReview $review): bool
    {
        return filled($review->checklist_snapshot['onboarding_questionnaire']['responses'] ?? null);
    }

    /**
     * @return array<string, mixed>
     */
    public function questionnaireResponses(DueDiligenceReview $review): array
    {
        return $review->checklist_snapshot['onboarding_questionnaire']['responses'] ?? [];
    }

    public function alreadySigned(DueDiligenceReview $review): bool
    {
        return $review->partnerAgreement()->exists();
    }

    /**
     * @param  array<string, mixed>  $questionnaire
     */
    public function renderAgreementBody(DueDiligenceReview $review, array $questionnaire): string
    {
        $view = $review->type === 'advertiser'
            ? 'onboarding.agreements.advertiser-body'
            : 'onboarding.agreements.publisher-body';

        return View::make($view, [
            'review' => $review,
            'questionnaire' => $questionnaire,
            'agreementId' => $this->agreementId($review),
        ])->render();
    }

    public function agreementId(DueDiligenceReview $review): string
    {
        $prefix = $review->type === 'advertiser' ? 'CL-ADV' : 'CL-PUB';

        return $prefix.'-'.str_pad((string) $review->application_id, 5, '0', STR_PAD_LEFT);
    }

    /**
     * @param  array<string, mixed>  $questionnaire
     */
    public function renderSignedAgreementBody(
        DueDiligenceReview $review,
        array $questionnaire,
        string $signerName,
        ?string $signerTitle,
        string $signatureImage,
        \DateTimeInterface $signedAt,
    ): string {
        return $this->renderAgreementBody($review, $questionnaire)
            .$this->renderSignatureBlock($review->type, $signerName, $signerTitle, $signatureImage, $signedAt);
    }

    public function renderSignatureBlock(
        string $type,
        string $signerName,
        ?string $signerTitle,
        string $signatureImage,
        \DateTimeInterface $signedAt,
    ): string {
        return View::make('onboarding.agreements.signature-block', [
            'type' => $type,
            'signerName' => $signerName,
            'signerTitle' => $signerTitle,
            'signatureImage' => $signatureImage,
            'signedAt' => $signedAt,
        ])->render();
    }

    public function renderAgreementBodyForEmail(PartnerAgreement $agreement): string
    {
        $agreement->loadMissing('dueDiligenceReview');

        $review = $agreement->dueDiligenceReview;
        $questionnaire = $agreement->questionnaire_snapshot ?? [];

        $bodyView = $agreement->type === 'advertiser'
            ? 'onboarding.agreements.email.advertiser-body'
            : 'onboarding.agreements.email.publisher-body';

        return View::make($bodyView, [
            'review' => $review,
            'questionnaire' => $questionnaire,
            'agreementId' => $this->agreementId($review),
            'signedAt' => $agreement->submitted_at,
        ])->render();
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    public function submit(
        DueDiligenceReview $review,
        array $payload,
        string $ip,
        ?string $userAgent,
    ): PartnerAgreement {
        if ($this->alreadySigned($review)) {
            throw new \RuntimeException('Agreement already submitted for this application.');
        }

        if (! $this->questionnaireCompleted($review)) {
            throw new \RuntimeException('Complete the onboarding questionnaire before signing.');
        }

        $questionnaire = $this->questionnaireResponses($review);
        $submittedAt = now();
        $signerName = (string) $payload['signer_name'];
        $signerTitle = filled($payload['signer_title'] ?? null) ? (string) $payload['signer_title'] : null;
        $signatureImage = (string) $payload['signature_data'];
        $agreementBody = $this->renderSignedAgreementBody(
            $review,
            $questionnaire,
            $signerName,
            $signerTitle,
            $signatureImage,
            $submittedAt,
        );

        $agreement = PartnerAgreement::create([
            'due_diligence_review_id' => $review->id,
            'partner_reference' => $review->partner_reference,
            'type' => $review->type,
            'agreement_version' => '2026-01',
            'questionnaire_snapshot' => $questionnaire,
            'agreement_body' => $agreementBody,
            'signer_name' => $signerName,
            'signer_title' => $signerTitle,
            'signature_image' => $signatureImage,
            'billing_model' => $review->type === 'advertiser' ? (string) $payload['billing_model'] : null,
            'signed_ip' => $ip,
            'signed_user_agent' => $userAgent,
            'submitted_at' => $submittedAt,
        ]);

        $this->dueDiligence->recordAgreementSubmission($review, $agreement);

        $this->sendAgreementCopies($agreement);

        return $agreement;
    }

    protected function sendAgreementCopies(PartnerAgreement $agreement): void
    {
        $agreement->load('dueDiligenceReview');
        $partnerEmail = (string) ($agreement->questionnaire_snapshot['contact_email'] ?? '');

        try {
            Mail::to('partners@convertlane.co.uk')->send(
                new OnboardingAgreementCopyMail($agreement, 'internal')
            );
        } catch (\Throwable $e) {
            Log::warning('Failed to email signed agreement to partners@', [
                'reference' => $agreement->partner_reference,
                'message' => $e->getMessage(),
            ]);
        }

        if (! filled($partnerEmail)) {
            return;
        }

        try {
            Mail::to($partnerEmail)->send(
                new OnboardingAgreementCopyMail($agreement, 'partner')
            );
        } catch (\Throwable $e) {
            Log::warning('Failed to email agreement copy to partner', [
                'reference' => $agreement->partner_reference,
                'email' => $partnerEmail,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
