<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_page_renders_form_with_honeypot(): void
    {
        $response = $this->get(route('contact'));

        $response->assertOk();
        $response->assertSee('name="_trap"', false);
        $response->assertSee('Send message');
    }
}
