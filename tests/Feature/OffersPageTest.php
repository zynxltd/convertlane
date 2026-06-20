<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class OffersPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Cache::forget('offer18.live_offers');
    }

    public function test_offers_page_shows_gate_when_no_offers_available(): void
    {
        config([
            'services.offer18.mid' => null,
            'services.offer18.api_key' => '',
            'services.offer18.secret_key' => '',
        ]);

        $this->get(route('offers'))
            ->assertOk()
            ->assertSee('Join the network to see live offers', false);
    }

    public function test_offers_page_lists_live_offers_from_offer18(): void
    {
        config([
            'services.offer18.mid' => 29509,
            'services.offer18.api_key' => 'test-api-key',
            'services.offer18.secret_key' => 'test-secret-key',
        ]);

        Http::fake([
            'api.offer18.com/api/m/offers*' => Http::response([
                'response' => '200',
                'data' => [
                    '21974787' => [
                        'offerid' => '21974787',
                        'offer_name' => 'Low Credit Finance',
                        'logo' => 'https://example.com/logo.gif',
                        'status' => 'Approved',
                        'category' => 'Finance, Loans',
                        'currency' => 'USD',
                        'price_affiliate' => '80%',
                        'model_affiliate' => 'CPS',
                        'price_advertiser' => '100%',
                        'model_advertiser' => 'CPS',
                        'advertiser_id' => '220714',
                        'visibility' => 'public + required approval',
                        'offer_description' => 'Low Credit Finance — US personal loans. GEO: USA',
                        'country_allow' => 'US',
                        'default_event' => 'initial',
                        'capping' => '',
                        'events' => '',
                    ],
                ],
            ]),
        ]);

        $this->get(route('offers'))
            ->assertOk()
            ->assertSee('Low Credit Finance', false)
            ->assertSee('21974787', false)
            ->assertSee('80% RevShare', false)
            ->assertDontSee('Join the network to see live offers', false);
    }
}
