<?php

namespace Tests\Feature;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdvertiserEnquiryTest extends TestCase
{
    use RefreshDatabase;

    public function test_advertiser_enquiry_page_renders(): void
    {
        $this->get(route('advertiser.enquiry'))->assertOk()->assertSee('Submit enquiry', false);
    }

    public function test_advertiser_enquiry_is_stored(): void
    {
        $this->post(route('advertiser.enquiry.store'), [
            'name' => 'Jane Smith',
            'email' => 'jane@brand.com',
            'company' => 'Acme Finance',
            'message' => 'We want to launch a CPA offer in the UK with a £40 payout.',
        ])->assertRedirect(route('advertiser.enquiry'));

        $this->assertDatabaseHas('contacts', [
            'email' => 'jane@brand.com',
            'subject' => 'Advertiser enquiry — Acme Finance',
        ]);
    }
}
