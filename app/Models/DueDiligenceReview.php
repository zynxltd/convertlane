<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DueDiligenceReview extends Model
{
    protected $fillable = [
        'application_id',
        'partner_reference',
        'type',
        'status',
        'risk_band',
        'risk_score',
        'documents_complete',
        'documents_requested_at',
        'documents_deadline_at',
        'pack_received_at',
        'sanctions_clear',
        'sanctions_checked_at',
        'pep_clear',
        'finance_approved',
        'finance_approved_by',
        'exposure_limit_gbp',
        'payment_terms',
        'compliance_signed_off',
        'compliance_signed_by',
        'compliance_signed_at',
        'am_signed_off',
        'am_signed_by',
        'am_signed_at',
        'affise_partner_id',
        'rejection_code',
        'rejection_notes',
        'internal_notes',
        'checklist_snapshot',
    ];

    protected function casts(): array
    {
        return [
            'documents_complete' => 'boolean',
            'documents_requested_at' => 'datetime',
            'documents_deadline_at' => 'datetime',
            'pack_received_at' => 'datetime',
            'sanctions_clear' => 'boolean',
            'sanctions_checked_at' => 'datetime',
            'pep_clear' => 'boolean',
            'finance_approved' => 'boolean',
            'exposure_limit_gbp' => 'decimal:2',
            'compliance_signed_off' => 'boolean',
            'compliance_signed_at' => 'datetime',
            'am_signed_off' => 'boolean',
            'am_signed_at' => 'datetime',
            'checklist_snapshot' => 'array',
        ];
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(DueDiligenceAuditLog::class);
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function canGoLive(): bool
    {
        if ($this->type === 'advertiser') {
            return $this->isApproved()
                && $this->compliance_signed_off
                && $this->finance_approved
                && $this->am_signed_off;
        }

        return $this->isApproved()
            && $this->compliance_signed_off
            && $this->am_signed_off
            && $this->sanctions_clear === true;
    }
}
