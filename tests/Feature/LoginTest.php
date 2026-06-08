<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_partner_login_page_renders(): void
    {
        $this->get(route('partner.login'))->assertOk()->assertSee('Partner login', false);
    }

    public function test_advertiser_login_page_renders(): void
    {
        $this->get(route('advertiser.login'))->assertOk()->assertSee('Advertiser login', false);
    }

    public function test_legacy_login_redirects_to_partner_login(): void
    {
        $this->get('/login')->assertRedirect('/partner/login');
    }

    public function test_partner_can_sign_in_via_offer18_api(): void
    {
        config([
            'services.offer18.mid' => 12345,
            'services.offer18.api_key' => 'test-api-key',
            'services.offer18.secret_key' => 'test-secret-key',
        ]);

        Http::fake([
            'api.offer18.com/api/m/affiliate_login' => Http::response([
                'status' => '200',
                'response' => 'affiliate_login_validated',
                'redirect_path' => 'https://convertlane.offer18.com/af/redirect?s=abc',
                'affiliate_id' => '1001',
            ]),
        ]);

        $this->post(route('partner.login.store'), [
            'email' => 'partner@example.com',
            'password' => 'secret-password',
        ])->assertRedirect('https://convertlane.offer18.com/af/redirect?s=abc');

        Http::assertSent(function ($request) {
            return $request->url() === 'https://api.offer18.com/api/m/affiliate_login'
                && $request['mail'] === 'partner@example.com'
                && $request['password'] === 'secret-password';
        });
    }

    public function test_advertiser_can_sign_in_via_offer18_api(): void
    {
        config([
            'services.offer18.mid' => 12345,
            'services.offer18.api_key' => 'test-api-key',
            'services.offer18.secret_key' => 'test-secret-key',
        ]);

        Http::fake([
            'api.offer18.com/api/m/advertiser_login' => Http::response([
                'status' => '200',
                'response' => 'advertiser_login_validated',
                'redirect_path' => 'https://convertlane.offer18.com/ad/redirect?s=xyz',
                'advertiser_id' => '2002',
            ]),
        ]);

        $this->post(route('advertiser.login.store'), [
            'email' => 'advertiser@example.com',
            'password' => 'secret-password',
        ])->assertRedirect('https://convertlane.offer18.com/ad/redirect?s=xyz');
    }

    public function test_invalid_credentials_are_rejected(): void
    {
        config([
            'services.offer18.mid' => 12345,
            'services.offer18.api_key' => 'test-api-key',
            'services.offer18.secret_key' => 'test-secret-key',
        ]);

        Http::fake([
            'api.offer18.com/api/m/affiliate_login' => Http::response([
                'status' => '400',
                'response' => 'invalid_credentials',
            ]),
        ]);

        $this->from(route('partner.login'))
            ->post(route('partner.login.store'), [
                'email' => 'partner@example.com',
                'password' => 'wrong-password',
            ])
            ->assertRedirect(route('partner.login'))
            ->assertSessionHasErrors('email');
    }

    public function test_partner_login_falls_back_to_panel_url_when_api_not_configured(): void
    {
        config([
            'services.offer18.mid' => null,
            'services.offer18.api_key' => '',
            'services.offer18.secret_key' => '',
            'services.offer18.partner_fallback_url' => 'https://convertlane.offer18.com',
        ]);

        $this->post(route('partner.login.store'), [
            'email' => 'partner@example.com',
            'password' => 'secret-password',
        ])->assertRedirect('https://convertlane.offer18.com');
    }
}
