<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Offer18 partner login and password reset APIs.
 *
 * @see https://knowledgebase.offer18.com/network/network-api/login-api
 * @see https://knowledgebase.offer18.com/network/network-api/affiliate-and-advertiser-password-reset
 */
class Offer18AuthService
{
    public function __construct(
        protected string $apiBase = '',
        protected ?int $mid = null,
        protected string $apiKey = '',
        protected string $secretKey = '',
        protected string $partnerFallbackUrl = '',
        protected string $advertiserFallbackUrl = '',
    ) {
        $config = config('services.offer18', []);

        $this->apiBase = rtrim($config['api_base'] ?? 'https://api.offer18.com', '/');
        $this->mid = filled($config['mid'] ?? null) ? (int) $config['mid'] : null;
        $this->apiKey = (string) ($config['api_key'] ?? '');
        $this->secretKey = (string) ($config['secret_key'] ?? '');
        $this->partnerFallbackUrl = (string) ($config['partner_fallback_url'] ?? '');
        $this->advertiserFallbackUrl = (string) ($config['advertiser_fallback_url'] ?? '');
    }

    public function isConfigured(): bool
    {
        return $this->mid !== null
            && $this->apiKey !== ''
            && $this->secretKey !== '';
    }

    /**
     * @return array{success: bool, redirect_url: ?string, message: ?string}
     */
    public function loginPartner(string $email, string $password): array
    {
        return $this->login('affiliate_login', $email, $password, $this->partnerFallbackUrl);
    }

    /**
     * @return array{success: bool, redirect_url: ?string, message: ?string}
     */
    public function loginAdvertiser(string $email, string $password): array
    {
        return $this->login('advertiser_login', $email, $password, $this->advertiserFallbackUrl);
    }

    /**
     * @return array{success: bool, redirect_url: ?string, message: ?string}
     */
    protected function login(string $endpoint, string $email, string $password, string $fallbackUrl): array
    {
        if (! $this->isConfigured()) {
            if (filled($fallbackUrl)) {
                Log::warning('Offer18 login API not configured; redirecting to panel login page', [
                    'endpoint' => $endpoint,
                ]);

                return [
                    'success' => true,
                    'redirect_url' => $fallbackUrl,
                    'message' => null,
                ];
            }

            return [
                'success' => false,
                'redirect_url' => null,
                'message' => 'Partner login is not configured yet. Contact support.',
            ];
        }

        $response = Http::timeout(15)
            ->asForm()
            ->post("{$this->apiBase}/api/m/{$endpoint}", [
                'mid' => $this->mid,
                'api-key' => $this->apiKey,
                'secret-key' => $this->secretKey,
                'mail' => $email,
                'password' => $password,
            ]);

        if ($response->failed()) {
            Log::warning('Offer18 login HTTP error', [
                'endpoint' => $endpoint,
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            return [
                'success' => false,
                'redirect_url' => null,
                'message' => 'Unable to sign in right now. Try again in a few minutes.',
            ];
        }

        $data = $response->json();

        if (($data['status'] ?? null) == 200 && filled($data['redirect_path'] ?? null)) {
            return [
                'success' => true,
                'redirect_url' => (string) $data['redirect_path'],
                'message' => null,
            ];
        }

        $responseCode = (string) ($data['response'] ?? '');

        Log::info('Offer18 login rejected', [
            'endpoint' => $endpoint,
            'status' => $data['status'] ?? null,
            'response' => $responseCode,
        ]);

        return [
            'success' => false,
            'redirect_url' => null,
            'message' => 'These credentials do not match our records. Use the email and password from your approval email.',
        ];
    }

    /**
     * @return array{success: bool, password: ?string, partner_id: ?string}
     */
    public function resetPartnerPassword(string $email): array
    {
        return $this->resetPassword('affiliate_password_reset', 'affiliate-email', $email);
    }

    /**
     * @return array{success: bool, password: ?string, partner_id: ?string}
     */
    public function resetAdvertiserPassword(string $email): array
    {
        return $this->resetPassword('advertiser_password_reset', 'advertiser-email', $email);
    }

    /**
     * @return array{success: bool, password: ?string, partner_id: ?string}
     */
    protected function resetPassword(string $endpoint, string $emailField, string $email): array
    {
        if (! $this->isConfigured()) {
            Log::warning('Offer18 password reset API not configured', ['endpoint' => $endpoint]);

            return ['success' => false, 'password' => null, 'partner_id' => null];
        }

        $response = Http::timeout(15)
            ->asForm()
            ->post("{$this->apiBase}/api/m/{$endpoint}", [
                'mid' => $this->mid,
                'api-key' => $this->apiKey,
                'secret-key' => $this->secretKey,
                $emailField => $email,
            ]);

        if ($response->failed()) {
            Log::warning('Offer18 password reset HTTP error', [
                'endpoint' => $endpoint,
                'status' => $response->status(),
            ]);

            return ['success' => false, 'password' => null, 'partner_id' => null];
        }

        $data = $response->json();

        if (($data['status'] ?? null) == 200 && filled($data['password'] ?? null)) {
            $idKey = str_contains($endpoint, 'advertiser') ? 'advertiser_id' : 'affiliate_id';

            return [
                'success' => true,
                'password' => (string) $data['password'],
                'partner_id' => isset($data[$idKey]) ? (string) $data[$idKey] : null,
            ];
        }

        Log::info('Offer18 password reset not completed', [
            'endpoint' => $endpoint,
            'status' => $data['status'] ?? null,
            'response' => $data['response'] ?? null,
        ]);

        return ['success' => false, 'password' => null, 'partner_id' => null];
    }
}
