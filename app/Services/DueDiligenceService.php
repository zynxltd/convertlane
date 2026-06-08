<?php

namespace App\Services;

use App\Models\Application;
use App\Models\DueDiligenceAuditLog;
use App\Models\DueDiligenceReview;
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
