<?php

namespace App\Services;

use App\Models\Application;
use App\Models\DueDiligenceAuditLog;
use App\Models\DueDiligenceReview;
use App\Models\PartnerAgreement;
use Illuminate\Support\Str;

class DueDiligenceService
{
    public function openReview(Application $application): DueDiligenceReview
    {
        $prefix = $application->type === 'advertiser' ? 'DD-A' : 'DD-P';
        $reference = $prefix.'-'.str_pad((string) $application->id, 5, '0', STR_PAD_LEFT);

        $review = DueDiligenceReview::create([
            'application_id' => $application->id,
            'partner_reference' => $reference,
            'type' => $application->type,
            'status' => 'applied',
        ]);

        $application->update([
            'partner_reference' => $reference,
            'dd_status' => 'applied',
        ]);

        $this->log($review, null, 'applied', 'Application received — DD review opened.');

        return $review;
    }

    public function transition(
        DueDiligenceReview $review,
        string $toStatus,
        ?string $actor = null,
        ?string $notes = null,
        array $meta = [],
    ): DueDiligenceReview {
        if (! in_array($toStatus, config('compliance.statuses'), true)) {
            throw new \InvalidArgumentException("Invalid DD status: {$toStatus}");
        }

        $from = $review->status;

        if (in_array($toStatus, ['rejected', 'on_hold', 'enhanced_dd'], true) && blank($notes)) {
            throw new \InvalidArgumentException('Notes are mandatory for this status change.');
        }

        if ($toStatus === 'approved' && ! $this->signOffsComplete($review)) {
            throw new \InvalidArgumentException('Cannot approve: required sign-offs or sanctions clearance missing.');
        }

        if ($toStatus === 'approved' && $review->risk_band === 'critical') {
            throw new \InvalidArgumentException('Cannot approve: critical risk band — Compliance Lead exception required in notes.');
        }

        $review->update(['status' => $toStatus]);
        $review->application?->update(['dd_status' => $toStatus]);

        if ($toStatus === 'documents_requested') {
            $days = config('compliance.document_sla_days', 7);
            $review->update([
                'documents_requested_at' => now(),
                'documents_deadline_at' => now()->addWeekdays($days),
            ]);
        }

        if ($toStatus === 'under_review' && ! $review->pack_received_at) {
            $review->update(['pack_received_at' => now()]);
        }

        $this->log($review, $from, $toStatus, $notes, $meta, $actor);

        return $review->fresh();
    }

    public function findReviewForQuestionnaire(string $type, ?string $reference, string $email): ?DueDiligenceReview
    {
        if (filled($reference)) {
            $byReference = DueDiligenceReview::query()
                ->where('partner_reference', $reference)
                ->where('type', $type)
                ->first();

            if ($byReference) {
                return $byReference;
            }
        }

        return DueDiligenceReview::query()
            ->where('type', $type)
            ->whereHas('application', fn ($query) => $query->where('email', $email))
            ->latest('id')
            ->first();
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    public function recordQuestionnaire(DueDiligenceReview $review, array $payload): void
    {
        $snapshot = $review->checklist_snapshot ?? [];
        $snapshot['onboarding_questionnaire'] = [
            'submitted_at' => now()->toIso8601String(),
            'responses' => $payload,
        ];

        $review->update(['checklist_snapshot' => $snapshot]);

        $this->log(
            $review,
            $review->status,
            $review->status,
            'Onboarding questionnaire received via web form.',
            ['partner_reference' => $review->partner_reference],
        );
    }

    public function recordAgreementSubmission(DueDiligenceReview $review, PartnerAgreement $agreement): void
    {
        $snapshot = $review->checklist_snapshot ?? [];
        $snapshot['partner_agreement'] = [
            'agreement_id' => $agreement->id,
            'submitted_at' => $agreement->submitted_at->toIso8601String(),
            'signer_name' => $agreement->signer_name,
            'billing_model' => $agreement->billing_model,
        ];

        $updates = ['checklist_snapshot' => $snapshot];

        if ($review->type === 'advertiser' && filled($agreement->billing_model)) {
            $updates['payment_terms'] = $agreement->billing_model === 'prepay'
                ? 'Prepay — funds before caps open'
                : 'Postpay — invoice Net-15/30 (subject to credit approval)';
        }

        $review->update($updates);

        if ($review->status === 'applied') {
            $this->transition(
                $review,
                'under_review',
                'partner',
                'Digital agreement signed — submitted for ConvertLane approval.',
                [
                    'agreement_id' => $agreement->id,
                    'billing_model' => $agreement->billing_model,
                ],
            );

            return;
        }

        $this->log(
            $review,
            $review->status,
            $review->status,
            'Digital agreement signed — submitted for ConvertLane approval.',
            ['agreement_id' => $agreement->id],
            'partner',
        );
    }

    public function calculateRiskBand(int $score): string
    {
        foreach (config('compliance.risk_bands') as $band => $range) {
            if ($score >= $range['min'] && $score <= $range['max']) {
                return $band;
            }
        }

        return 'critical';
    }

    public function updateRiskScore(DueDiligenceReview $review, int $score): DueDiligenceReview
    {
        $band = $this->calculateRiskBand($score);

        $review->update([
            'risk_score' => $score,
            'risk_band' => $band,
        ]);

        $this->log($review, $review->status, $review->status, "Risk score set to {$score} ({$band}).", ['score' => $score], 'system');

        return $review->fresh();
    }

    protected function signOffsComplete(DueDiligenceReview $review): bool
    {
        if ($review->sanctions_clear !== true) {
            return false;
        }

        if (! $review->compliance_signed_off) {
            return false;
        }

        if (! $review->am_signed_off) {
            return false;
        }

        if ($review->type === 'advertiser' && ! $review->finance_approved) {
            return false;
        }

        return true;
    }

    protected function log(
        DueDiligenceReview $review,
        ?string $from,
        string $to,
        ?string $notes = null,
        array $meta = [],
        ?string $actor = null,
    ): void {
        DueDiligenceAuditLog::create([
            'due_diligence_review_id' => $review->id,
            'actor' => $actor ?? 'system',
            'from_status' => $from,
            'to_status' => $to,
            'notes' => $notes,
            'meta' => $meta ?: null,
        ]);
    }
}
