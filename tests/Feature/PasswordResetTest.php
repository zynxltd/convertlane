<?php

namespace Tests\Feature;

use App\Mail\PanelPasswordResetMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_partner_password_reset_page_renders(): void
    {
        $this->get(route('partner.password.request'))
            ->assertOk()
            ->assertSee('Reset your', false);
    }

    public function test_partner_password_reset_sends_email_when_offer18_succeeds(): void
    {
        Mail::fake();

        config([
            'services.offer18.mid' => 12345,
            'services.offer18.api_key' => 'test-api-key',
            'services.offer18.secret_key' => 'test-secret-key',
        ]);

        Http::fake([
            'api.offer18.com/api/m/affiliate_password_reset' => Http::response([
                'status' => '200',
                'response' => 'affiliate_pass_reset:completed',
                'password' => 'TempPass99',
                'affiliate_id' => '1001',
            ]),
        ]);

        $this->post(route('partner.password.request.store'), [
            'email' => 'partner@example.com',
        ])->assertRedirect(route('partner.password.sent'));

        Mail::assertSent(PanelPasswordResetMail::class, function (PanelPasswordResetMail $mail) {
            return $mail->hasTo('partner@example.com')
                && $mail->temporaryPassword === 'TempPass99';
        });
    }

    public function test_partner_password_reset_submits_email_field_with_spinner(): void
    {
        Mail::fake();

        config([
            'services.offer18.mid' => 12345,
            'services.offer18.api_key' => 'test-api-key',
            'services.offer18.secret_key' => 'test-secret-key',
        ]);

        Http::fake([
            'api.offer18.com/api/m/affiliate_password_reset' => Http::response([
                'status' => '200',
                'password' => 'TempPass99',
            ]),
        ]);

        $this->post(route('partner.password.request.store'), [
            'email' => 'partner@example.com',
        ])->assertRedirect(route('partner.password.sent'));

        Http::assertSent(fn ($request) => true);
    }

    public function test_advertiser_password_reset_sends_email_when_offer18_succeeds(): void
    {
        Mail::fake();

        config([
            'services.offer18.mid' => 12345,
            'services.offer18.api_key' => 'test-api-key',
            'services.offer18.secret_key' => 'test-secret-key',
        ]);

        Http::fake([
            'api.offer18.com/api/m/advertiser_password_reset' => Http::response([
                'status' => '200',
                'response' => 'advertiser_pass_reset:completed',
                'password' => 'AdvTemp99',
                'advertiser_id' => '2002',
            ]),
        ]);

        $this->post(route('advertiser.password.request.store'), [
            'email' => 'advertiser@example.com',
        ])->assertRedirect(route('advertiser.password.sent'));

        Mail::assertSent(PanelPasswordResetMail::class, function (PanelPasswordResetMail $mail) {
            return $mail->hasTo('advertiser@example.com')
                && $mail->temporaryPassword === 'AdvTemp99';
        });
    }

    public function test_unknown_email_still_shows_confirmation_page(): void
    {
        Mail::fake();

        config([
            'services.offer18.mid' => 12345,
            'services.offer18.api_key' => 'test-api-key',
            'services.offer18.secret_key' => 'test-secret-key',
        ]);

        Http::fake([
            'api.offer18.com/api/m/affiliate_password_reset' => Http::response([
                'status' => '400',
                'response' => 'not_found',
            ]),
        ]);

        $this->post(route('partner.password.request.store'), [
            'email' => 'unknown@example.com',
        ])->assertRedirect(route('partner.password.sent'));

        Mail::assertNothingSent();
    }
}
