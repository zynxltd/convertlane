<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'brand',
        'brand_slug',
        'in_house',
        'vertical',
        'model',
        'payout',
        'event',
        'geos',
        'traffic',
        'cap',
        'status',
        'epc_hint',
        'description',
        'is_published',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'geos' => 'array',
            'traffic' => 'array',
            'in_house' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * @return array<string, mixed>
     */
    public function toCatalogArray(): array
    {
        return [
            'id' => $this->slug,
            'name' => $this->name,
            'brand' => $this->brand,
            'brand_slug' => $this->brand_slug ?? str($this->brand)->slug()->toString(),
            'in_house' => $this->in_house,
            'vertical' => $this->vertical,
            'model' => $this->model,
            'payout' => $this->payout,
            'event' => $this->event,
            'geos' => $this->geos ?? [],
            'traffic' => $this->traffic ?? [],
            'cap' => $this->cap ?? '—',
            'status' => $this->status,
            'epc_hint' => $this->epc_hint ?? '—',
            'description' => $this->description ?? '',
        ];
    }
}
