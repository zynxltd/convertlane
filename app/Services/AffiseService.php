<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Affise API integration stub.
 * @see https://api.affise.com/docs
 */
class AffiseService
{
    public function __construct(
        protected string $apiUrl = '',
        protected string $apiKey = '',
    ) {
        $this->apiUrl = config('services.affise.url', 'https://api.affise.com');
        $this->apiKey = config('services.affise.key', '');
    }

    public function isConfigured(): bool
    {
        return $this->apiKey !== '';
    }

    /**
     * Register affiliate application in Affise (custom field / webhook flow).
     */
    public function submitPartnerApplication(array $payload): ?array
    {
        if (! $this->isConfigured()) {
            Log::info('Affise not configured; application queued locally', $payload);

            return null;
        }

        $response = Http::withHeaders([
            'API-Key' => $this->apiKey,
        ])->post("{$this->apiUrl}/3.0/admin/partner", $payload);

        if ($response->failed()) {
            Log::error('Affise partner submission failed', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            return null;
        }

        return $response->json();
    }

    public function trackingUrl(string $offerId, string $pid): string
    {
        $base = rtrim(config('brand.affise_url'), '/');

        return "{$base}/click?offer_id={$offerId}&pid={$pid}";
    }
}
