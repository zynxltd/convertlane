<?php

namespace App\Console\Commands;

use App\Services\Offer18AuthService;
use App\Services\Offer18PartnerService;
use App\Models\Application;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TestOffer18ApiCommand extends Command
{
    protected $signature = 'offer18:test
                            {--affiliate-email= : Live affiliate login email}
                            {--affiliate-password= : Live affiliate login password}
                            {--advertiser-email= : Live advertiser login email}
                            {--advertiser-password= : Live advertiser login password}';

    protected $description = 'Test all Offer18 Network API integrations';

    /** @var array<string, bool> */
    protected array $results = [];

    public function handle(Offer18AuthService $auth, Offer18PartnerService $partners): int
    {
        $config = config('services.offer18');

        if (! $auth->isConfigured()) {
            $this->error('Offer18 API not configured. Set OFFER18_MID, OFFER18_API_KEY, OFFER18_SECRET_KEY in .env');

            return self::FAILURE;
        }

        $this->info('Offer18 API configured (mid: '.$config['mid'].')');
        $this->newLine();

        $base = rtrim($config['api_base'], '/');
        $authParams = [
            'mid' => $config['mid'],
            'api-key' => $config['api_key'],
            'secret-key' => $config['secret_key'],
        ];

        $this->section('Login APIs');
        $this->testInvalidLogin($auth, 'affiliate');
        $this->testInvalidLogin($auth, 'advertiser');

        if ($this->option('affiliate-email') && $this->option('affiliate-password')) {
            $this->testLiveLogin($auth, 'affiliate', (string) $this->option('affiliate-email'), (string) $this->option('affiliate-password'));
        }

        if ($this->option('advertiser-email') && $this->option('advertiser-password')) {
            $this->testLiveLogin($auth, 'advertiser', (string) $this->option('advertiser-email'), (string) $this->option('advertiser-password'));
        }

        $this->newLine();
        $this->section('Password reset APIs');
        $this->testPasswordResetProbe($base, $authParams, 'affiliate_password_reset', 'affiliate-email');
        $this->testPasswordResetProbe($base, $authParams, 'advertiser_password_reset', 'advertiser-email');

        $this->newLine();
        $this->section('Join / create (Pending)');
        $this->testPendingCreate($partners, 'publisher');
        $this->testPendingCreate($partners, 'advertiser');

        $this->newLine();
        $this->table(['Test', 'Result'], collect($this->results)->map(fn ($ok, $name) => [$name, $ok ? 'PASS' : 'FAIL'])->values()->all());

        $failed = collect($this->results)->contains(fn ($ok) => ! $ok);

        if ($failed) {
            $this->error('One or more tests failed.');

            return self::FAILURE;
        }

        $this->info('All Offer18 API tests passed.');

        return self::SUCCESS;
    }

    protected function section(string $title): void
    {
        $this->line("<fg=cyan>{$title}</>");
    }

    protected function testInvalidLogin(Offer18AuthService $auth, string $type): void
    {
        $result = $type === 'affiliate'
            ? $auth->loginPartner('offer18-api-test@invalid.example', 'invalid')
            : $auth->loginAdvertiser('offer18-api-test@invalid.example', 'invalid');

        $ok = ! $result['success'];
        $this->results["{$type} login (invalid creds rejected)"] = $ok;
        $this->line($ok ? "  ✓ {$type} login rejects invalid credentials" : "  ✗ {$type} login unexpected success");
    }

    protected function testLiveLogin(Offer18AuthService $auth, string $type, string $email, string $password): void
    {
        $result = $type === 'affiliate'
            ? $auth->loginPartner($email, $password)
            : $auth->loginAdvertiser($email, $password);

        $ok = $result['success'] && filled($result['redirect_url']);
        $this->results["{$type} login (live credentials)"] = $ok;
        $host = $ok ? parse_url((string) $result['redirect_url'], PHP_URL_HOST) : 'n/a';
        $this->line($ok ? "  ✓ {$type} login OK → {$host}" : "  ✗ {$type} login failed");
    }

    /**
     * @param  array<string, mixed>  $authParams
     */
    protected function testPasswordResetProbe(string $base, array $authParams, string $endpoint, string $emailField): void
    {
        $response = Http::timeout(15)->asForm()->post("{$base}/api/m/{$endpoint}", [
            ...$authParams,
            $emailField => 'offer18-api-test@invalid.example',
        ]);

        $status = (string) ($response->json('status') ?? '');
        $ok = $response->successful() && $status === '400';
        $label = str_replace('_password_reset', '', $endpoint);
        $this->results["{$label} password reset (API reachable)"] = $ok;
        $this->line($ok ? "  ✓ {$label} password reset API responds" : "  ✗ {$label} password reset API error");
    }

    protected function testPendingCreate(Offer18PartnerService $partners, string $type): void
    {
        $email = 'offer18-test-'.$type.'-'.time().'@convertlane.co.uk';
        $application = new Application([
            'type' => $type === 'publisher' ? 'publisher' : 'advertiser',
            'first_name' => 'API',
            'last_name' => 'Test',
            'email' => $email,
            'company' => 'API Test Ltd',
            'country' => 'GB',
        ]);

        $result = $partners->createFromApplication($application, '127.0.0.1');
        $ok = $result['success'] && filled($result['partner_id']);
        $label = $type === 'publisher' ? 'affiliate' : 'advertiser';
        $this->results["create pending {$label}"] = $ok;
        $this->line($ok
            ? "  ✓ pending {$label} created (id: {$result['partner_id']})"
            : "  ✗ pending {$label} create failed ({$result['reason']})");
    }
}
