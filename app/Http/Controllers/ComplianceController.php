<?php

namespace App\Http\Controllers;

use App\Models\DueDiligenceReview;
use App\Services\DueDiligenceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ComplianceController extends Controller
{
    public function index(Request $request): View
    {
        $reviews = DueDiligenceReview::query()
            ->with('application')
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->when($request->type, fn ($q, $t) => $q->where('type', $t))
            ->latest()
            ->paginate(20);

        return view('compliance.index', [
            'reviews' => $reviews,
            'statuses' => config('compliance.statuses'),
        ]);
    }

    public function show(DueDiligenceReview $review): View
    {
        $review->load(['application', 'partnerAgreement', 'auditLogs' => fn ($q) => $q->latest()]);

        return view('compliance.show', [
            'review' => $review,
            'rejectCodes' => config('compliance.reject_codes.'.$review->type, []),
        ]);
    }

    public function update(Request $request, DueDiligenceReview $review, DueDiligenceService $dd): RedirectResponse
    {
        $validated = $request->validate([
            'action' => ['required', 'in:transition,score,signoff,reject'],
            'actor' => ['required', 'string', 'max:100'],
            'to_status' => ['nullable', 'string'],
            'notes' => ['nullable', 'string', 'max:5000'],
            'risk_score' => ['nullable', 'integer', 'min:0', 'max:200'],
            'rejection_code' => ['nullable', 'string'],
            'exposure_limit_gbp' => ['nullable', 'numeric', 'min:0'],
            'payment_terms' => ['nullable', 'string', 'max:100'],
            'affise_partner_id' => ['nullable', 'string', 'max:50'],
            'internal_notes' => ['nullable', 'string', 'max:10000'],
        ]);

        $actor = $validated['actor'];

        $review->update([
            'sanctions_clear' => $request->has('sanctions_clear') ? true : $review->sanctions_clear,
            'sanctions_checked_at' => $request->has('sanctions_clear') ? now() : $review->sanctions_checked_at,
            'pep_clear' => $request->has('pep_clear') ? true : $review->pep_clear,
            'documents_complete' => $request->boolean('documents_complete'),
            'compliance_signed_off' => $request->boolean('compliance_signed_off'),
            'compliance_signed_by' => $request->boolean('compliance_signed_off') ? $actor : $review->compliance_signed_by,
            'compliance_signed_at' => $request->boolean('compliance_signed_off') ? now() : $review->compliance_signed_at,
            'am_signed_off' => $request->boolean('am_signed_off'),
            'am_signed_by' => $request->boolean('am_signed_off') ? $actor : $review->am_signed_by,
            'am_signed_at' => $request->boolean('am_signed_off') ? now() : $review->am_signed_at,
            'finance_approved' => $review->type === 'advertiser' ? $request->boolean('finance_approved') : $review->finance_approved,
            'finance_approved_by' => $request->boolean('finance_approved') ? $actor : $review->finance_approved_by,
            'exposure_limit_gbp' => $validated['exposure_limit_gbp'] ?? $review->exposure_limit_gbp,
            'payment_terms' => $validated['payment_terms'] ?? $review->payment_terms,
            'affise_partner_id' => $validated['affise_partner_id'] ?? $review->affise_partner_id,
            'internal_notes' => $validated['internal_notes'] ?? $review->internal_notes,
        ]);

        if ($request->has('sanctions_clear')) {
            $review->update(['sanctions_clear' => true, 'sanctions_checked_at' => now()]);
        }

        if ($validated['action'] === 'score' && isset($validated['risk_score'])) {
            $dd->updateRiskScore($review->fresh(), (int) $validated['risk_score']);
        }

        if ($validated['action'] === 'transition' && ! empty($validated['to_status'])) {
            $dd->transition($review->fresh(), $validated['to_status'], $actor, $validated['notes'] ?? null);
        }

        if ($validated['action'] === 'reject') {
            $request->validate(['rejection_code' => ['required', 'string'], 'notes' => ['required', 'string']]);
            $review->update([
                'rejection_code' => $validated['rejection_code'],
                'rejection_notes' => $validated['notes'],
            ]);
            $dd->transition($review->fresh(), 'rejected', $actor, $validated['notes']);
        }

        return redirect()
            ->route('compliance.show', $review)
            ->with('success', 'Review updated.');
    }
}
