<?php

namespace App\Mail;

use App\Models\PartnerAgreement;
use App\Services\PartnerAgreementService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OnboardingAgreementCopyMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public PartnerAgreement $agreement,
        public string $audience = 'internal',
    ) {}

    public function envelope(): Envelope
    {
        $type = $this->agreement->type === 'advertiser' ? 'Advertiser' : 'Affiliate';
        $ref = $this->agreement->partner_reference;

        $subject = $this->audience === 'partner'
            ? "Your ConvertLane {$type} Agreement — {$ref}"
            : "Signed {$type} agreement — {$ref} — {$this->agreement->signer_name}";

        $envelope = new Envelope(subject: $subject);

        if ($this->audience === 'internal') {
            $partnerEmail = $this->agreement->questionnaire_snapshot['contact_email'] ?? null;
            if (filled($partnerEmail)) {
                $envelope = $envelope->replyTo([$partnerEmail]);
            }
        }

        return $envelope;
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.onboarding-agreement-copy',
            with: [
                'emailAgreementBody' => app(PartnerAgreementService::class)
                    ->renderAgreementBodyForEmail($this->agreement),
            ],
        );
    }
}
