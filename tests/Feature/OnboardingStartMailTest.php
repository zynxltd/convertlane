<?php

namespace Tests\Feature;

use App\Mail\OnboardingStartMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class OnboardingStartMailTest extends TestCase
{
    use RefreshDatabase;

    public function test_apply_sends_onboarding_start_email_with_questionnaire_link(): void
    {
        Mail::fake();

        config([
            'services.offer18.mid' => 29509,
            'services.offer18.api_key' => 'test-api-key',
            'services.offer18.secret_key' => 'test-secret-key',
            'brand.public_url' => 'https://convertlane.co.uk',
        ]);

        Http::fake([
            'api.offer18.com/api/m/affiliate' => Http::response([
                'status' => '200',
                'response' => 'affiliate_created_successfully',
                'data' => [
                    'affiliate_id' => 760999,
                    'email' => 'partner@example.com',
                    'password' => 'generated-pass',
                ],
            ]),
        ]);

        $this->post(route('apply.store'), [
            'type' => 'publisher',
            'first_name' => 'Jane',
            'last_name' => 'Publisher',
            'email' => 'partner@example.com',
            'company' => 'Example Media Ltd',
            'company_number' => '12345678',
            'website' => 'https://example.com',
            'country' => 'GB',
            'traffic_sources' => 'SEO and paid social across UK geos.',
            'monthly_volume' => '£5k – £25k',
            'message' => 'Interested in finance offers.',
            'terms' => '1',
        ])->assertRedirect(route('apply.success'));

        Mail::assertSent(OnboardingStartMail::class, function (OnboardingStartMail $mail) {
            return $mail->hasTo('partner@example.com')
                && $mail->partnerType === 'publisher'
                && str_contains($mail->questionnaireUrl, 'https://convertlane.co.uk/onboarding/publisher')
                && str_contains($mail->questionnaireUrl, 'email=partner%40example.com');
        });
    }
}

