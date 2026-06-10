<?php

namespace Tests\Feature;

use App\Mail\OnboardingAgreementCopyMail;
use App\Models\Application;
use App\Models\PartnerAgreement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class OnboardingAgreementTest extends TestCase
{
    use RefreshDatabase;

  private const SIGNATURE = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg==';

    public function test_questionnaire_redirects_to_agreement(): void
    {
        $this->createReview('publisher', 'DD-P-00001');

        $this->post(route('onboarding.publisher.store'), $this->publisherPayload('DD-P-00001'))
            ->assertRedirect(route('onboarding.publisher.agreement', [
                'email' => 'publisher@example.com',
                'ref' => 'DD-P-00001',
            ]));
    }

    public function test_publisher_agreement_page_requires_questionnaire(): void
    {
        $this->createReview('publisher', 'DD-P-00002');

        $this->get(route('onboarding.publisher.agreement', [
            'email' => 'publisher@example.com',
            'ref' => 'DD-P-00002',
        ]))
            ->assertRedirect(route('onboarding.publisher', [
                'email' => 'publisher@example.com',
                'ref' => 'DD-P-00002',
            ]));
    }

    public function test_publisher_agreement_page_shows_confirm_details_step(): void
    {
        $this->createReviewWithQuestionnaire('publisher', 'DD-P-00005');

        $this->get(route('onboarding.publisher.agreement', [
            'email' => 'publisher@example.com',
            'ref' => 'DD-P-00005',
        ]))
            ->assertOk()
            ->assertSee('Confirm your details', false)
            ->assertSee('Continue to agreement', false)
            ->assertSee('Example Media', false);
    }

    public function test_publisher_can_submit_signed_agreement(): void
    {
        Mail::fake();

        $review = $this->createReviewWithQuestionnaire('publisher', 'DD-P-00003');

        $this->post(route('onboarding.publisher.agreement.store'), [
            'partner_reference' => 'DD-P-00003',
            'contact_email' => 'publisher@example.com',
            'signer_name' => 'Jane Publisher',
            'signer_title' => 'Director',
            'signature_data' => self::SIGNATURE,
            'accept_agreement' => '1',
            'accept_terms' => '1',
        ])
            ->assertRedirect(route('onboarding.agreement.success'))
            ->assertSessionHas('onboarding_agreement_reference', 'DD-P-00003');

        $this->assertDatabaseHas('partner_agreements', [
            'partner_reference' => 'DD-P-00003',
            'type' => 'publisher',
            'signer_name' => 'Jane Publisher',
        ]);

        $review->refresh();
        $this->assertSame('under_review', $review->status);
        $this->assertTrue($review->partnerAgreement()->exists());

        $agreement = $review->partnerAgreement;
        $this->assertStringContainsString('Signatures', $agreement->agreement_body);
        $this->assertStringContainsString(self::SIGNATURE, $agreement->agreement_body);
        $this->assertStringContainsString('Jane Publisher', $agreement->agreement_body);
        $this->assertStringContainsString('Director', $agreement->agreement_body);

        Mail::assertSent(OnboardingAgreementCopyMail::class, function (OnboardingAgreementCopyMail $mail) {
            return $mail->hasTo('partners@convertlane.co.uk')
                && $mail->audience === 'internal'
                && $mail->agreement->partner_reference === 'DD-P-00003';
        });

        Mail::assertSent(OnboardingAgreementCopyMail::class, function (OnboardingAgreementCopyMail $mail) {
            return $mail->hasTo('publisher@example.com')
                && $mail->audience === 'partner'
                && $mail->agreement->partner_reference === 'DD-P-00003';
        });
    }

    public function test_publisher_agreement_email_excludes_io_language(): void
    {
        Mail::fake();

        $this->createReviewWithQuestionnaire('publisher', 'DD-P-00006');

        $this->post(route('onboarding.publisher.agreement.store'), [
            'partner_reference' => 'DD-P-00006',
            'contact_email' => 'publisher@example.com',
            'signer_name' => 'Jane Publisher',
            'signature_data' => self::SIGNATURE,
            'accept_agreement' => '1',
            'accept_terms' => '1',
        ]);

        Mail::assertSent(OnboardingAgreementCopyMail::class, function (OnboardingAgreementCopyMail $mail) {
            return $mail->audience === 'partner'
                && ! str_contains($mail->agreement->agreement_body, 'Insertion Order');
        });
    }

    public function test_agreement_email_body_uses_email_safe_html(): void
    {
        $review = $this->createReviewWithQuestionnaire('publisher', 'DD-P-00007');

        $agreement = $review->partnerAgreement()->create([
            'partner_reference' => 'DD-P-00007',
            'type' => 'publisher',
            'agreement_version' => '2026-01',
            'questionnaire_snapshot' => $this->publisherQuestionnaire(),
            'agreement_body' => '<div class="test">web</div>',
            'signer_name' => 'Jane Publisher',
            'signature_image' => self::SIGNATURE,
            'submitted_at' => now(),
        ]);

        $html = app(\App\Services\PartnerAgreementService::class)
            ->renderAgreementBodyForEmail($agreement);

        $this->assertStringNotContainsString('class="mt-6', $html);
        $this->assertStringNotContainsString('Insertion Order', $html);
    }

    public function test_agreement_copy_mail_embeds_signature_image(): void
    {
        $review = $this->createReviewWithQuestionnaire('publisher', 'DD-P-00008');

        $agreement = $review->partnerAgreement()->create([
            'partner_reference' => 'DD-P-00008',
            'type' => 'publisher',
            'agreement_version' => '2026-01',
            'questionnaire_snapshot' => $this->publisherQuestionnaire(),
            'agreement_body' => '<p>Agreement</p>',
            'signer_name' => 'Jane Publisher',
            'signature_image' => self::SIGNATURE,
            'submitted_at' => now(),
        ]);

        $html = (new OnboardingAgreementCopyMail($agreement, 'partner'))->render();

        $this->assertStringContainsString('alt="Signature of Jane Publisher"', $html);
        $this->assertMatchesRegularExpression('/<img[^>]+src=["\'](?:cid:|data:image\/png)/', $html);
    }

    public function test_advertiser_agreement_stores_billing_model(): void
    {
        $review = $this->createReviewWithQuestionnaire('advertiser', 'DD-A-00001', true);

        $this->post(route('onboarding.advertiser.agreement.store'), [
            'partner_reference' => 'DD-A-00001',
            'contact_email' => 'advertiser@example.com',
            'signer_name' => 'Alex Advertiser',
            'signature_data' => self::SIGNATURE,
            'billing_model' => 'postpay',
            'accept_agreement' => '1',
            'accept_terms' => '1',
        ])->assertRedirect(route('onboarding.agreement.success'));

        $agreement = PartnerAgreement::query()->where('partner_reference', 'DD-A-00001')->first();
        $this->assertSame('postpay', $agreement->billing_model);

        $review->refresh();
        $this->assertStringContainsString('Postpay', $review->payment_terms ?? '');
    }

    public function test_cannot_sign_agreement_twice(): void
    {
        $this->createReviewWithQuestionnaire('publisher', 'DD-P-00004');

        $payload = [
            'partner_reference' => 'DD-P-00004',
            'contact_email' => 'publisher@example.com',
            'signer_name' => 'Jane Publisher',
            'signature_data' => self::SIGNATURE,
            'accept_agreement' => '1',
            'accept_terms' => '1',
        ];

        $this->post(route('onboarding.publisher.agreement.store'), $payload);
        $this->post(route('onboarding.publisher.agreement.store'), $payload)
            ->assertRedirect()
            ->assertSessionHas('error');
    }

    private function createReview(string $type, string $reference): void
    {
        $isAdvertiser = $type === 'advertiser';

        $application = Application::create([
            'type' => $type,
            'first_name' => $isAdvertiser ? 'Alex' : 'Jane',
            'last_name' => $isAdvertiser ? 'Advertiser' : 'Publisher',
            'email' => $isAdvertiser ? 'advertiser@example.com' : 'publisher@example.com',
            'company' => $isAdvertiser ? 'Example Adv Ltd' : 'Example Media',
            'partner_reference' => $reference,
            'dd_status' => 'applied',
        ]);

        $application->dueDiligenceReview()->create([
            'partner_reference' => $reference,
            'type' => $type,
            'status' => 'applied',
        ]);
    }

    /**
     * @return \App\Models\DueDiligenceReview
     */
    private function createReviewWithQuestionnaire(string $type, string $reference, bool $useAdvertiserEmail = false)
    {
        $isAdvertiser = $type === 'advertiser' || $useAdvertiserEmail;

        $application = Application::create([
            'type' => $type,
            'first_name' => $isAdvertiser ? 'Alex' : 'Jane',
            'last_name' => $isAdvertiser ? 'Advertiser' : 'Publisher',
            'email' => $isAdvertiser ? 'advertiser@example.com' : 'publisher@example.com',
            'company' => $isAdvertiser ? 'Example Adv Ltd' : 'Example Media',
            'partner_reference' => $reference,
            'dd_status' => 'applied',
        ]);

        return $application->dueDiligenceReview()->create([
            'partner_reference' => $reference,
            'type' => $type,
            'status' => 'applied',
            'checklist_snapshot' => [
                'onboarding_questionnaire' => [
                    'submitted_at' => now()->toIso8601String(),
                    'responses' => $isAdvertiser
                        ? array_merge($this->advertiserQuestionnaire(), ['partner_reference' => $reference])
                        : array_merge($this->publisherQuestionnaire(), ['partner_reference' => $reference]),
                ],
            ],
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function publisherPayload(string $reference = 'DD-P-00001'): array
    {
        return [
            'partner_reference' => $reference,
            'contact_email' => 'publisher@example.com',
            'contact_name' => 'Jane Publisher',
            'entity_type' => 'company',
            'company_name' => 'Example Media',
            'website' => 'https://example.com',
            'country' => 'GB',
            'traffic_sources' => 'SEO',
            'promo_channels' => 'https://example.com',
            'confirm_id_required' => '1',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function publisherQuestionnaire(): array
    {
        return [
            'partner_reference' => 'DD-P-00003',
            'contact_email' => 'publisher@example.com',
            'contact_name' => 'Jane Publisher',
            'entity_type' => 'company',
            'company_name' => 'Example Media',
            'country' => 'GB',
            'traffic_sources' => 'SEO',
            'promo_channels' => 'https://example.com',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function advertiserQuestionnaire(): array
    {
        return [
            'partner_reference' => 'DD-A-00001',
            'contact_email' => 'advertiser@example.com',
            'contact_name' => 'Alex Advertiser',
            'entity_type' => 'company',
            'company_name' => 'Example Adv Ltd',
            'website' => 'https://example.com',
            'country' => 'GB',
            'vertical' => 'Finance',
            'landing_pages' => 'https://example.com/lp',
            'postback_url' => 'https://postback.example.com',
        ];
    }
}
