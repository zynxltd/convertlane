<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ApplicationOffer18Test extends TestCase
{
    use RefreshDatabase;

    public function test_publisher_application_creates_pending_offer18_affiliate(): void
    {
        config([
            'services.offer18.mid' => 29509,
            'services.offer18.api_key' => 'test-api-key',
            'services.offer18.secret_key' => 'test-secret-key',
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

        $this->post(route('apply.store'), $this->validPublisherPayload())
            ->assertRedirect(route('apply.success'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('applications', [
            'email' => 'partner@example.com',
            'offer18_partner_id' => '760999',
            'offer18_partner_type' => 'affiliate',
            'offer18_sync_status' => 'created_pending',
        ]);

        Http::assertSent(function ($request) {
            return $request->url() === 'https://api.offer18.com/api/m/affiliate'
                && $request['action'] === 'create'
                && $request['status'] === 'Pending'
                && $request['email'] === 'partner@example.com';
        });
    }

    public function test_advertiser_application_creates_pending_offer18_advertiser(): void
    {
        config([
            'services.offer18.mid' => 29509,
            'services.offer18.api_key' => 'test-api-key',
            'services.offer18.secret_key' => 'test-secret-key',
        ]);

        Http::fake([
            'api.offer18.com/api/m/advertiser' => Http::response([
                'status' => '200',
                'response' => 'advertiser_created_successfully',
                'data' => [
                    'advertiser_id' => 219999,
                    'email' => 'advertiser@example.com',
                    'password' => 'generated-pass',
                ],
            ]),
        ]);

        $payload = array_merge($this->validPublisherPayload(), [
            'type' => 'advertiser',
            'email' => 'advertiser@example.com',
            'traffic_sources' => null,
        ]);

        $this->post(route('apply.store'), $payload)
            ->assertRedirect(route('apply.success'));

        $this->assertDatabaseHas('applications', [
            'email' => 'advertiser@example.com',
            'offer18_partner_id' => '219999',
            'offer18_partner_type' => 'advertiser',
            'offer18_sync_status' => 'created_pending',
        ]);
    }

    public function test_existing_offer18_email_still_saves_application(): void
    {
        config([
            'services.offer18.mid' => 29509,
            'services.offer18.api_key' => 'test-api-key',
            'services.offer18.secret_key' => 'test-secret-key',
        ]);

        Http::fake([
            'api.offer18.com/api/m/affiliate' => Http::response([
                'status' => '400',
                'response' => 'affiliate_already_exists',
            ]),
        ]);

        $this->post(route('apply.store'), $this->validPublisherPayload())
            ->assertRedirect(route('apply.success'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('applications', [
            'email' => 'partner@example.com',
            'offer18_sync_status' => 'skipped_exists',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function validPublisherPayload(): array
    {
        return [
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
        ];
    }
}
