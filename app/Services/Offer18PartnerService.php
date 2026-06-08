<?php

namespace App\Services;

use App\Models\Application;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Create affiliate/advertiser accounts in Offer18 on application.
 *
 * @see https://knowledgebase.offer18.com/network/network-api/affiliate-and-advertiser-create-api
 */
class Offer18PartnerService
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
     * @return array{success: bool, partner_id: ?string, reason: ?string}
     */
    public function createFromApplication(Application $application, string $signupIp): array
    {
        if (! $this->isConfigured()) {
            Log::info('Offer18 partner create skipped — API not configured', [
                'application_id' => $application->id,
            ]);

            return ['success' => false, 'partner_id' => null, 'reason' => 'not_configured'];
        }

        $endpoint = $application->type === 'advertiser' ? 'advertiser' : 'affiliate';
        $password = Str::password(16);

        $payload = [
            'mid' => $this->mid,
            'api-key' => $this->apiKey,
            'secret-key' => $this->secretKey,
            'action' => 'create',
            'status' => 'Pending',
            'first_name' => $application->first_name,
            'last_name' => $application->last_name,
            'email' => $application->email,
            'password' => $password,
            'company' => $application->company,
            'country' => $application->country ?? 'GB',
            'signup_ip' => $signupIp,
        ];

        $response = Http::timeout(15)
            ->asForm()
            ->post("{$this->apiBase}/api/m/{$endpoint}", $payload);

        if ($response->failed()) {
            Log::warning('Offer18 partner create HTTP error', [
                'application_id' => $application->id,
                'endpoint' => $endpoint,
                'status' => $response->status(),
            ]);

            return ['success' => false, 'partner_id' => null, 'reason' => 'http_error'];
        }

        $data = $response->json();
        $status = (string) ($data['status'] ?? '');
        $responseCode = (string) ($data['response'] ?? '');

        if ($status === '200' && is_array($data['data'] ?? null)) {
            $idKey = $endpoint === 'advertiser' ? 'advertiser_id' : 'affiliate_id';
            $partnerId = isset($data['data'][$idKey]) ? (string) $data['data'][$idKey] : null;

            Log::info('Offer18 partner created (pending)', [
                'application_id' => $application->id,
                'endpoint' => $endpoint,
                'partner_id' => $partnerId,
            ]);

            return ['success' => true, 'partner_id' => $partnerId, 'reason' => null];
        }

        if ($responseCode === 'affiliate_already_exists' || $responseCode === 'advertiser_already_exists') {
            Log::info('Offer18 partner already exists', [
                'application_id' => $application->id,
                'email' => $application->email,
            ]);

            return ['success' => false, 'partner_id' => null, 'reason' => 'already_exists'];
        }

        Log::warning('Offer18 partner create rejected', [
            'application_id' => $application->id,
            'endpoint' => $endpoint,
            'status' => $status,
            'response' => $responseCode,
        ]);

        return ['success' => false, 'partner_id' => null, 'reason' => $responseCode ?: 'rejected'];
    }
}
