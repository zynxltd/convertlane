<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Application extends Model
{
    protected $fillable = [
        'type',
        'first_name',
        'last_name',
        'email',
        'company',
        'company_number',
        'website',
        'country',
        'incorporation_country',
        'incorporated_at',
        'traffic_sources',
        'monthly_volume',
        'message',
        'status',
        'dd_status',
        'partner_reference',
        'offer18_partner_id',
        'offer18_partner_type',
        'offer18_sync_status',
    ];

    protected function casts(): array
    {
        return [
            'incorporated_at' => 'date',
        ];
    }

    public function dueDiligenceReview(): HasOne
    {
        return $this->hasOne(DueDiligenceReview::class);
    }
}
