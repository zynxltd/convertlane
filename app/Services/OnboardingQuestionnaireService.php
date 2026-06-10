<?php

namespace App\Services;

use App\Models\Contact;
use Illuminate\Support\Facades\Log;

class OnboardingQuestionnaireService
{
    public function __construct(
        protected DueDiligenceService $dueDiligence,
    ) {}

    /**
     * @param  array<string, mixed>  $payload
     */
    public function persistOrLog(string $type, array $payload): bool
    {
        $email = (string) ($payload['contact_email'] ?? '');
        $reference = filled($payload['partner_reference'] ?? null)
            ? (string) $payload['partner_reference']
            : null;

        $review = $this->dueDiligence->findReviewForQuestionnaire($type, $reference, $email);

        if ($review) {
            $this->dueDiligence->recordQuestionnaire($review, $payload);

            return true;
        }

        Log::warning('Onboarding questionnaire submitted without matching DD review — stored as contact', [
            'type' => $type,
            'email' => $email,
            'reference' => $reference,
        ]);

        Contact::create([
            'name' => (string) ($payload['contact_name'] ?? 'Onboarding applicant'),
            'email' => $email,
            'subject' => 'Onboarding questionnaire — '.$type.($reference ? " ({$reference})" : ''),
            'message' => json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) ?: '',
            'status' => 'new',
        ]);

        return true;
    }
}
