<?php

namespace App\Services;

use App\Models\Application;
use App\Models\Contact;
use Illuminate\Support\Facades\Log;

class OnboardingQuestionnaireService
{
    public function __construct(
        protected DueDiligenceService $dueDiligence,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function prefill(string $type, ?string $reference, ?string $email): array
    {
        $review = null;

        if (filled($reference) || filled($email)) {
            $review = $this->dueDiligence->findReviewForQuestionnaire(
                $type,
                filled($reference) ? (string) $reference : null,
                (string) ($email ?? ''),
            );
        }

        $application = $review?->application;

        if (! $application && filled($email)) {
            $application = Application::query()
                ->where('type', $type)
                ->where('email', $email)
                ->latest('id')
                ->first();
        }

        $prefill = array_filter([
            'partner_reference' => $reference ?? $application?->partner_reference,
            'contact_email' => $email ?? $application?->email,
        ], fn ($value) => filled($value));

        if (! $application) {
            return $prefill;
        }

        return array_merge($prefill, array_filter([
            'contact_name' => trim("{$application->first_name} {$application->last_name}"),
            'company_name' => $application->company,
            'company_number' => $application->company_number,
            'website' => $this->displayWebsite($application->website),
            'country' => $application->country,
            'traffic_sources' => $application->traffic_sources,
            'monthly_volume' => $application->monthly_volume,
            'notes' => $application->message,
        ], fn ($value) => filled($value)));
    }

    protected function displayWebsite(?string $website): ?string
    {
        if (blank($website)) {
            return null;
        }

        $display = preg_replace('/^https?:\/\//i', '', $website);

        return filled($display) ? $display : $website;
    }

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
