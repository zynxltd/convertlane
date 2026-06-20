<?php

namespace App\Services;

use App\Models\Offer;
use Illuminate\Support\Facades\Schema;

class OfferCatalog
{
    public function __construct(
        protected Offer18OffersService $offer18Offers,
    ) {}

    /**
     * @return list<array<string, mixed>>
     */
    public function live(): array
    {
        if ($this->offersTableReady() && Offer::query()->exists()) {
            return $this->excludePrivate(
                $this->enrich(
                    Offer::query()->published()->ordered()->get()
                        ->map(fn (Offer $offer) => $offer->toCatalogArray())
                        ->all()
                )
            );
        }

        $fromOffer18 = $this->offer18Offers->liveCatalog();

        if ($fromOffer18 !== []) {
            return $this->excludePrivate($this->enrich($fromOffer18));
        }

        return $this->excludePrivate($this->enrich(config('offers.live', [])));
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function inHouseBrands(): array
    {
        $fromOffers = collect($this->live())
            ->where('in_house', true)
            ->unique('brand_slug')
            ->map(fn (array $offer) => [
                'slug' => $offer['brand_slug'],
                'name' => $offer['brand'],
                'tagline' => $offer['name'],
            ])
            ->values()
            ->all();

        if ($fromOffers !== []) {
            return $fromOffers;
        }

        return config('offers.in_house_brands', []);
    }

    /**
     * @return list<array{name: string, slug: string, logo: ?string}>
     */
    public function partnerBrands(): array
    {
        return collect($this->live())
            ->unique('brand_slug')
            ->map(fn (array $offer) => [
                'name' => $offer['brand'],
                'slug' => $offer['brand_slug'],
                'logo' => null,
            ])
            ->values()
            ->all();
    }

    /**
     * @return array{verticals: list<array>, models: list<string>, geos: list<string>, brands: list<string>}
     */
    public function filterOptions(): array
    {
        $offers = $this->live();

        return [
            'verticals' => config('brand.verticals', []),
            'models' => collect($offers)->pluck('model')->unique()->sort()->values()->all(),
            'geos' => collect($offers)->pluck('geos')->flatten()->unique()->sort()->values()->all(),
            'brands' => collect($offers)->pluck('brand')->unique()->sort()->values()->all(),
        ];
    }

    public function counts(): array
    {
        $offers = collect($this->live());

        return [
            'total' => $offers->count(),
            'in_house' => $offers->where('in_house', true)->count(),
            'partner' => $offers->where('in_house', false)->count(),
            'live' => $offers->where('status', 'live')->count(),
        ];
    }

    /**
     * @param  list<array<string, mixed>>  $offers
     * @return list<array<string, mixed>>
     */
    protected function enrich(array $offers): array
    {
        $verticals = collect(config('brand.verticals', []))->keyBy('slug');

        return collect($offers)
            ->map(function (array $offer) use ($verticals) {
                $vertical = $verticals->get($offer['vertical']);

                return array_merge($offer, [
                    'vertical_name' => $vertical['name'] ?? ucfirst($offer['vertical']),
                    'vertical_icon' => $vertical['icon'] ?? 'banknotes',
                ]);
            })
            ->values()
            ->all();
    }

    /**
     * @param  list<array<string, mixed>>  $offers
     * @return list<array<string, mixed>>
     */
    protected function excludePrivate(array $offers): array
    {
        return collect($offers)
            ->where('status', '!=', 'private')
            ->values()
            ->all();
    }

    protected function offersTableReady(): bool
    {
        try {
            return Schema::hasTable('offers');
        } catch (\Throwable) {
            return false;
        }
    }
}
