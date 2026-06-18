<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FormValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_apply_requires_valid_publisher_payload(): void
    {
        $response = $this->post(route('apply.store'), []);

        $response->assertSessionHasErrors([
            'type',
            'first_name',
            'last_name',
            'email',
            'company',
            'company_number',
            'website',
            'country',
            'monthly_volume',
            'terms',
        ]);
    }

    public function test_apply_requires_traffic_sources_for_publishers(): void
    {
        $response = $this->post(route('apply.store'), $this->validPublisherPayload([
            'traffic_sources' => 'short',
        ]));

        $response->assertSessionHasErrors('traffic_sources');
    }

    public function test_apply_accepts_valid_publisher_application(): void
    {
        $response = $this->post(route('apply.store'), $this->validPublisherPayload());

        $response->assertRedirect(route('apply.success'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('applications', [
            'email' => 'partner@example.com',
            'type' => 'publisher',
        ]);
    }

    public function test_contact_requires_valid_payload(): void
    {
        $response = $this->post(route('contact.store'), []);

        $response->assertSessionHasErrors(['name', 'email', 'subject', 'message']);
    }

    public function test_contact_silently_accepts_honeypot_spam(): void
    {
        $response = $this->post(route('contact.store'), $this->validContactPayload([
            '_trap' => 'spam',
        ]));

        $response->assertRedirect(route('contact'));
        $response->assertSessionHas('success');
        $response->assertSessionMissing('error');
        $this->assertDatabaseMissing('contacts', [
            'email' => 'alex@example.com',
        ]);
    }

    public function test_contact_accepts_valid_message(): void
    {
        $response = $this->post(route('contact.store'), $this->validContactPayload());

        $response->assertRedirect(route('contact'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('contacts', [
            'email' => 'alex@example.com',
            'subject' => 'Partnerships',
            'status' => 'new',
        ]);
    }

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function validPublisherPayload(array $overrides = []): array
    {
        return array_merge([
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
        ], $overrides);
    }

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function validContactPayload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Alex Smith',
            'email' => 'alex@example.com',
            'subject' => 'Partnerships',
            'message' => 'I would like to discuss a partnership opportunity.',
        ], $overrides);
    }
}
