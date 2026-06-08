<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DueDiligenceAuditLog extends Model
{
    protected $fillable = [
        'due_diligence_review_id',
        'actor',
        'from_status',
        'to_status',
        'notes',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'meta' => 'array',
        ];
    }

    public function review(): BelongsTo
    {
        return $this->belongsTo(DueDiligenceReview::class, 'due_diligence_review_id');
    }
}
