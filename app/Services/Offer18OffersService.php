<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Fetch live offers from the Offer18 Network Offers API.
 *
 * @see https://knowledgebase.offer18.com/network/network-api/offers-api
 */
class Offer18OffersService
{
    public function __construct(
        protected string $apiBase = '',
        protected ?int $mid = null,
        protected string $apiKey = '',
        protected string $secretKey = '',
    ) {
        $config = config('services.offer18', []);

        $this->apiBase = rtrim($config['api_base'] ?? 'https://api.offer18.com', '/');
        $this->mid = filled($config['mid'] ?? null) ? (int) $config['mid'] : null;
        $this->apiKey = (string) ($config['api_key'] ?? '');
        $this->secretKey = (string) ($config['secret_key'] ?? '');
    }

    public function isConfigured(): bool
    {
        return $this->mid !== null
            && $this->apiKey !== ''
            && $this->secretKey !== '';
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function liveCatalog(): array
    {
        if (! $this->isConfigured()) {
            return [];
        }

        $cached = Cache::get('offer18.live_offers');

        if (is_array($cached)) {
            return $cached;
        }

        $result = $this->fetchApprovedOffers();

        if (! $result['ok']) {
            return [];
        }

        $catalog = collect($result['offers'])
            ->map(fn (array $offer) => $this->toCatalogArray($offer))
            ->sortBy('name')
            ->values()
            ->all();

        Cache::put('offer18.live_offers', $catalog, now()->addMinutes(15));

        return $catalog;
    }

    /**
     * @return array{ok: bool, offers: list<array<string, mixed>>}
     */
    protected function fetchApprovedOffers(): array
    {
        $offers = [];
        $page = 1;

        do {
            $query = [
                'mid' => $this->mid,
                'api-key' => $this->apiKey,
                'secret-key' => $this->secretKey,
                'action' => 'list',
                'status' => '1',
                'limit' => 100,
            ];

            if ($page > 1) {
                $query['page'] = $page;
            }

            $response = Http::timeout(20)->get("{$this->apiBase}/api/m/offers", $query);

            if ($response->failed()) {
                Log::warning('Offer18 offers API HTTP error', [
                    'status' => $response->status(),
                    'page' => $page,
                ]);

                return ['ok' => false, 'offers' => []];
            }

            $data = $response->json();

            if ((string) ($data['response'] ?? '') !== '200') {
                Log::warning('Offer18 offers API rejected', [
                    'response' => $data['response'] ?? null,
                    'page' => $page,
                ]);

                return ['ok' => false, 'offers' => []];
            }

            $batch = is_array($data['data'] ?? null) ? array_values($data['data']) : [];

            if ($batch === []) {
                break;
            }

            $offers = array_merge($offers, $batch);
            $page++;
        } while (count($batch) === 100);

        return ['ok' => true, 'offers' => $offers];
    }

    /**
     * @param  array<string, mixed>  $offer
     * @return array<string, mixed>
     */
    protected function toCatalogArray(array $offer): array
    {
        $offerId = (string) ($offer['offerid'] ?? '');
        $name = trim((string) ($offer['offer_name'] ?? 'Untitled offer'));
        $category = trim((string) ($offer['category'] ?? ''));
        $model = strtoupper(trim((string) ($offer['model_affiliate'] ?? 'CPA')));
        $currency = strtoupper(trim((string) ($offer['currency'] ?? 'USD')));
        $price = trim((string) ($offer['price_affiliate'] ?? ''));
        $description = $this->plainDescription((string) ($offer['offer_description'] ?? ''));

        return [
            'id' => $offerId !== '' ? $offerId : Str::slug($name),
            'name' => $name,
            'brand' => $this->resolveBrand($name, $category),
            'brand_slug' => Str::slug($this->resolveBrand($name, $category)),
            'in_house' => false,
            'vertical' => $this->mapVertical($category, $description),
            'model' => $model,
            'payout' => $this->formatPayout($price, $currency, $model),
            'event' => $this->resolveEvent($offer),
            'geos' => $this->resolveGeos($offer, $description),
            'traffic' => [],
            'cap' => $this->formatCap($offer['capping'] ?? null),
            'status' => $this->mapStatus((string) ($offer['visibility'] ?? '')),
            'epc_hint' => '—',
            'description' => $description,
            'logo' => filled($offer['logo'] ?? null) ? (string) $offer['logo'] : null,
        ];
    }

    protected function resolveBrand(string $name, string $category): string
    {
        if ($category !== '') {
            $primary = trim(explode(',', $category)[0]);

            if ($primary !== '' && ! str_contains(strtolower($primary), 'loan')) {
                return $primary;
            }
        }

        return $name;
    }

    protected function mapVertical(string $category, string $description): string
    {
        $haystack = strtolower($category.' '.$description);

        return match (true) {
            str_contains($haystack, 'igaming') || str_contains($haystack, 'betting') || str_contains($haystack, 'casino') => 'igaming',
            str_contains($haystack, 'health') || str_contains($haystack, 'wellness') || str_contains($haystack, 'nutra') => 'health',
            str_contains($haystack, 'saas') || str_contains($haystack, 'b2b') => 'saas',
            str_contains($haystack, 'ecommerce') || str_contains($haystack, 'e-commerce') || str_contains($haystack, 'retail') => 'ecommerce',
            str_contains($haystack, 'dating') || str_contains($haystack, 'social') => 'dating',
            str_contains($haystack, 'finance') || str_contains($haystack, 'loan') || str_contains($haystack, 'fintech') => 'finance',
            default => 'finance',
        };
    }

    protected function formatPayout(string $price, string $currency, string $model): string
    {
        if ($price === '') {
            return '—';
        }

        if (str_contains($price, '%')) {
            return $price.' '.($model === 'CPS' ? 'RevShare' : $model);
        }

        $symbol = match ($currency) {
            'GBP' => '£',
            'EUR' => '€',
            'USD' => '$',
            default => $currency.' ',
        };

        return $symbol.$price.' '.$model;
    }

    /**
     * @param  array<string, mixed>  $offer
     */
    protected function resolveEvent(array $offer): string
    {
        $events = $offer['events'] ?? null;

        if (is_array($events) && isset($events[0]['event_name'])) {
            return (string) $events[0]['event_name'];
        }

        $default = trim((string) ($offer['default_event'] ?? ''));

        return $default !== '' && $default !== 'initial' ? ucfirst($default) : 'Conversion';
    }

    /**
     * @param  array<string, mixed>  $offer
     * @return list<string>
     */
    protected function resolveGeos(array $offer, string $description): array
    {
        $countryAllow = trim((string) ($offer['country_allow'] ?? ''));

        if ($countryAllow !== '') {
            return collect(explode(',', $countryAllow))
                ->map(fn (string $geo) => strtoupper(trim($geo)))
                ->filter()
                ->unique()
                ->values()
                ->all();
        }

        if (preg_match('/\bGEO:\s*([^<\n\r]+)/i', $description, $matches)) {
            $geoText = trim($matches[1]);

            if (preg_match('/\b(US|USA|UK|GB|IE|CA|AU|DE|FR|ES|IT|NL|BR|MX)\b/i', $geoText, $geoMatch)) {
                return [strtoupper($geoMatch[1] === 'USA' ? 'US' : $geoMatch[1])];
            }
        }

        return ['—'];
    }

    protected function formatCap(mixed $capping): string
    {
        if (! is_array($capping) || $capping === []) {
            return 'Open';
        }

        $first = $capping[0] ?? null;

        if (! is_array($first)) {
            return 'Open';
        }

        $value = $first['value'] ?? null;
        $period = $first['period'] ?? null;

        if ($value === null || $value === '') {
            return 'Open';
        }

        return trim((string) $value.' / '.($period ?: 'period'));
    }

    protected function mapStatus(string $visibility): string
    {
        $visibility = strtolower($visibility);

        if (str_contains($visibility, 'private')) {
            return 'private';
        }

        if (str_contains($visibility, 'limited') || str_contains($visibility, 'cap')) {
            return 'limited';
        }

        return 'live';
    }

    protected function plainDescription(string $html): string
    {
        $text = html_entity_decode(strip_tags(str_replace(['<br />', '<br/>', '<br>'], "\n", $html)));
        $text = preg_replace("/\n{2,}/", "\n", $text) ?? $text;

        return trim(Str::limit($text, 280));
    }
}
