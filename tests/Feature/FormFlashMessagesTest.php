<?php

namespace Tests\Feature;

use App\Models\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class FormFlashMessagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_apply_success_page_redirects_without_session_reference(): void
    {
        $this->get(route('apply.success'))
            ->assertRedirect(route('apply'));
    }

    public function test_apply_success_page_renders_with_session_data(): void
    {
        $this->withSession([
            'apply_reference' => 'DD-P-00001',
            'apply_email' => 'partner@example.com',
            'apply_type' => 'publisher',
            'success' => 'Application received (ref: DD-P-00001).',
        ])->get(route('apply.success'))
            ->assertOk()
            ->assertSee('Application received (ref: DD-P-00001).', false)
            ->assertSee('DD-P-00001', false);
    }

    public function test_onboarding_success_shows_message_and_hides_form(): void
    {
        Mail::fake();

        $response = $this->post(route('onboarding.publisher.store'), [
            'partner_reference' => 'DD-P-00001',
            'contact_email' => 'publisher@example.com',
            'contact_name' => 'Jane Publisher',
            'entity_type' => 'individual',
            'website' => 'https://example.com',
            'country' => 'GB',
            'traffic_sources' => 'SEO and paid social.',
            'promo_channels' => 'https://example.com',
            'confirm_id_required' => '1',
        ]);

        $response->assertRedirect(route('onboarding.publisher', [
            'email' => 'publisher@example.com',
            'ref' => 'DD-P-00001',
        ]));
        $response->assertSessionHas('success');

        $this->followRedirects($response)
            ->assertOk()
            ->assertSee('review your answers', false)
            ->assertDontSee('Submit questionnaire', false);
    }

    public function test_onboarding_validation_shows_error_summary(): void
    {
        Mail::fake();

        $response = $this->from(route('onboarding.publisher'))
            ->post(route('onboarding.publisher.store'), [
                'contact_email' => 'bad',
            ]);

        $response->assertRedirect(route('onboarding.publisher'))
            ->assertSessionHasErrors('contact_email');

        $this->followRedirects($response)
            ->assertOk()
            ->assertSee('value="bad"', false)
            ->assertSee('Submit questionnaire', false);
    }

    public function test_onboarding_mail_failure_still_succeeds_when_questionnaire_is_persisted(): void
    {
        Mail::shouldReceive('to')->once()->andReturnSelf();
        Mail::shouldReceive('send')->once()->andThrow(new \RuntimeException('SMTP failure'));

        $application = Application::create([
            'type' => 'publisher',
            'first_name' => 'Jane',
            'last_name' => 'Publisher',
            'email' => 'publisher@example.com',
            'company' => 'Example Media Ltd',
            'partner_reference' => 'DD-P-00001',
            'dd_status' => 'applied',
        ]);

        $application->dueDiligenceReview()->create([
            'partner_reference' => 'DD-P-00001',
            'type' => 'publisher',
            'status' => 'applied',
        ]);

        $response = $this->from(route('onboarding.publisher'))
            ->post(route('onboarding.publisher.store'), [
                'partner_reference' => 'DD-P-00001',
                'contact_email' => 'publisher@example.com',
                'contact_name' => 'Jane Publisher',
                'entity_type' => 'individual',
                'website' => 'https://example.com',
                'country' => 'GB',
                'traffic_sources' => 'SEO and paid social.',
                'promo_channels' => 'https://example.com',
                'confirm_id_required' => '1',
            ]);

        $response->assertRedirect(route('onboarding.publisher', [
            'email' => 'publisher@example.com',
            'ref' => 'DD-P-00001',
        ]))
            ->assertSessionHas('success')
            ->assertSessionMissing('error');

        $this->followRedirects($response)
            ->assertOk()
            ->assertSee('review your answers', false)
            ->assertDontSee('could not submit your questionnaire', false);
    }

    public function test_apply_submission_failure_logs_error_and_shows_flash(): void
    {
        Application::creating(function () {
            throw new \RuntimeException('Simulated database failure');
        });

        Log::shouldReceive('error')
            ->once()
            ->withArgs(function (string $message, array $context) {
                return $message === 'Application submission failed'
                    && ($context['email'] ?? null) === 'partner@example.com';
            });

        $response = $this->from(route('apply'))
            ->post(route('apply.store'), [
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
            ]);

        $response->assertRedirect(route('apply'))
            ->assertSessionHas('error')
            ->assertSessionHasInput('email', 'partner@example.com');

        $this->followRedirects($response)
            ->assertOk()
            ->assertSee('could not submit your application', false);
    }
}
