<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PartnerAgreement extends Model
{
    protected $fillable = [
        'due_diligence_review_id',
        'partner_reference',
        'type',
        'agreement_version',
        'questionnaire_snapshot',
        'agreement_body',
        'signer_name',
        'signer_title',
        'signature_image',
        'billing_model',
        'signed_ip',
        'signed_user_agent',
        'submitted_at',
    ];

    protected function casts(): array
    {
        return [
            'questionnaire_snapshot' => 'array',
            'submitted_at' => 'datetime',
        ];
    }

    public function dueDiligenceReview(): BelongsTo
    {
        return $this->belongsTo(DueDiligenceReview::class);
    }

    public function isPrepay(): bool
    {
        return $this->billing_model === 'prepay';
    }

    public function isPostpay(): bool
    {
        return $this->billing_model === 'postpay';
    }
}
