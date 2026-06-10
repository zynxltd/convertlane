<?php

namespace Tests\Feature;

use App\Mail\OnboardingQuestionnaireMail;
use App\Models\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class OnboardingQuestionnaireTest extends TestCase
{
    use RefreshDatabase;

    public function test_publisher_onboarding_page_renders(): void
    {
        $this->get(route('onboarding.publisher', ['email' => 'pub@example.com', 'ref' => 'DD-P-00001']))
            ->assertOk()
            ->assertSee('Publisher', false);
    }

    public function test_advertiser_onboarding_page_renders(): void
    {
        $this->get(route('onboarding.advertiser', ['email' => 'adv@example.com', 'ref' => 'DD-A-00001']))
            ->assertOk()
            ->assertSee('Advertiser', false);
    }

    public function test_publisher_questionnaire_sends_mail_to_partners(): void
    {
        Mail::fake();

        $this->post(route('onboarding.publisher.store'), [
            'partner_reference' => 'DD-P-00001',
            'contact_email' => 'publisher@example.com',
            'contact_name' => 'Jane Publisher',
            'entity_type' => 'individual',
            'website' => 'https://example.com',
            'country' => 'GB',
            'traffic_sources' => 'SEO and paid social.',
            'promo_channels' => 'https://example.com',
            'confirm_id_required' => '1',
        ])->assertRedirect(route('onboarding.publisher.agreement', [
            'email' => 'publisher@example.com',
            'ref' => 'DD-P-00001',
        ]));

        Mail::assertSent(OnboardingQuestionnaireMail::class, function (OnboardingQuestionnaireMail $mail) {
            return $mail->hasTo('partners@convertlane.co.uk')
                && ($mail->payload['type'] ?? null) === 'publisher'
                && ($mail->payload['partner_reference'] ?? null) === 'DD-P-00001';
        });
    }

    public function test_advertiser_questionnaire_sends_mail_to_partners(): void
    {
        Mail::fake();

        $this->post(route('onboarding.advertiser.store'), [
            'partner_reference' => 'DD-A-00002',
            'contact_email' => 'advertiser@example.com',
            'contact_name' => 'Alex Advertiser',
            'entity_type' => 'company',
            'company_name' => 'Example Adv Ltd',
            'website' => 'https://example.com',
            'country' => 'GB',
            'vertical' => 'Finance',
            'landing_pages' => 'https://example.com/lp',
            'postback_url' => 'https://postback.example.com/?cid={clickid}',
            'confirm_id_required' => '1',
        ])->assertRedirect(route('onboarding.advertiser.agreement', [
            'email' => 'advertiser@example.com',
            'ref' => 'DD-A-00002',
        ]));

        Mail::assertSent(OnboardingQuestionnaireMail::class, function (OnboardingQuestionnaireMail $mail) {
            return $mail->hasTo('partners@convertlane.co.uk')
                && ($mail->payload['type'] ?? null) === 'advertiser'
                && ($mail->payload['partner_reference'] ?? null) === 'DD-A-00002';
        });
    }

    public function test_publisher_questionnaire_persists_to_due_diligence_review(): void
    {
        Mail::fake();

        $application = Application::create([
            'type' => 'publisher',
            'first_name' => 'Jane',
            'last_name' => 'Publisher',
            'email' => 'publisher@example.com',
            'company' => 'Example Media Ltd',
            'partner_reference' => 'DD-P-00001',
            'dd_status' => 'applied',
        ]);

        $review = $application->dueDiligenceReview()->create([
            'partner_reference' => 'DD-P-00001',
            'type' => 'publisher',
            'status' => 'applied',
        ]);

        $this->post(route('onboarding.publisher.store'), [
            'partner_reference' => 'DD-P-00001',
            'contact_email' => 'publisher@example.com',
            'contact_name' => 'Jane Publisher',
            'entity_type' => 'individual',
            'website' => 'https://example.com',
            'country' => 'GB',
            'traffic_sources' => 'SEO and paid social.',
            'promo_channels' => 'https://example.com',
            'confirm_id_required' => '1',
        ])->assertRedirect();

        $review->refresh();

        $this->assertSame('Jane Publisher', $review->checklist_snapshot['onboarding_questionnaire']['responses']['contact_name'] ?? null);
        $this->assertSame('publisher@example.com', $review->checklist_snapshot['onboarding_questionnaire']['responses']['contact_email'] ?? null);
    }

    public function test_publisher_questionnaire_prefills_from_application(): void
    {
        Application::create([
            'type' => 'publisher',
            'first_name' => 'Jane',
            'last_name' => 'Publisher',
            'email' => 'publisher@example.com',
            'company' => 'Example Media Ltd',
            'company_number' => '12345678',
            'website' => 'https://example.com',
            'country' => 'GB',
            'traffic_sources' => 'SEO and paid social.',
            'monthly_volume' => '£5k – £25k',
            'partner_reference' => 'DD-P-00001',
            'dd_status' => 'applied',
        ]);

        $this->get(route('onboarding.publisher', [
            'email' => 'publisher@example.com',
            'ref' => 'DD-P-00001',
        ]))
            ->assertOk()
            ->assertSee('value="Jane Publisher"', false)
            ->assertSee('value="Example Media Ltd"', false)
            ->assertSee('value="example.com"', false)
            ->assertSee('SEO and paid social.', false);
    }

    public function test_publisher_validation_redirect_preserves_input_and_query_params(): void
    {
        Mail::fake();

        $response = $this->from(route('onboarding.publisher', [
            'email' => 'publisher@example.com',
            'ref' => 'DD-P-00001',
        ]))->post(route('onboarding.publisher.store'), [
            'partner_reference' => 'DD-P-00001',
            'contact_email' => 'publisher@example.com',
            'contact_name' => 'Jane Publisher',
            'entity_type' => 'company',
            'website' => 'example.com',
            'country' => 'GB',
            'traffic_sources' => 'SEO',
            'promo_channels' => 'https://example.com',
        ]);

        $response->assertRedirect(route('onboarding.publisher', [
            'email' => 'publisher@example.com',
            'ref' => 'DD-P-00001',
        ]))
            ->assertSessionHasErrors(['confirm_id_required']);

        $this->followRedirects($response)
            ->assertOk()
            ->assertSee('value="Jane Publisher"', false)
            ->assertSee('value="publisher@example.com"', false)
            ->assertSee('value="DD-P-00001"', false)
            ->assertSee('value="example.com"', false)
            ->assertSee('SEO', false)
            ->assertSee('Submit questionnaire', false);
    }

    public function test_publisher_questionnaire_requires_core_fields(): void
    {
        Mail::fake();

        $this->from(route('onboarding.publisher'))
            ->post(route('onboarding.publisher.store'), [
                'contact_email' => 'bad',
            ])
            ->assertRedirect(route('onboarding.publisher', [
                'email' => 'bad',
            ]))
            ->assertSessionHasErrors([
                'contact_email',
                'contact_name',
                'entity_type',
                'country',
                'traffic_sources',
                'promo_channels',
                'confirm_id_required',
            ]);

        Mail::assertNothingSent();
    }

    public function test_publisher_questionnaire_allows_missing_website(): void
    {
        Mail::fake();

        $this->post(route('onboarding.publisher.store'), [
            'partner_reference' => 'DD-P-00004',
            'contact_email' => 'publisher@example.com',
            'contact_name' => 'Jane Publisher',
            'entity_type' => 'individual',
            'country' => 'GB',
            'traffic_sources' => 'SEO and paid social.',
            'promo_channels' => 'https://example.com',
            'confirm_id_required' => '1',
        ])->assertRedirect(route('onboarding.publisher.agreement', [
            'email' => 'publisher@example.com',
            'ref' => 'DD-P-00004',
        ]));

        Mail::assertSent(OnboardingQuestionnaireMail::class, function (OnboardingQuestionnaireMail $mail) {
            return ($mail->payload['website'] ?? null) === null;
        });
    }

    public function test_advertiser_questionnaire_requires_core_fields(): void
    {
        Mail::fake();

        $this->from(route('onboarding.advertiser'))
            ->post(route('onboarding.advertiser.store'), [
                'contact_email' => 'bad',
            ])
            ->assertRedirect(route('onboarding.advertiser', [
                'email' => 'bad',
            ]))
            ->assertSessionHasErrors([
                'contact_email',
                'contact_name',
                'entity_type',
                'company_name',
                'website',
                'country',
                'vertical',
                'landing_pages',
                'postback_url',
                'confirm_id_required',
            ]);

        Mail::assertNothingSent();
    }
}

