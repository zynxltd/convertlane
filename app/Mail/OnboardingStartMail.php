<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OnboardingStartMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $partnerType, // publisher | advertiser
        public string $reference,
        public string $questionnaireUrl,
    ) {}

    public function envelope(): Envelope
    {
        $label = $this->partnerType === 'advertiser' ? 'Advertiser' : 'Publisher';

        return new Envelope(
            subject: "Next step: {$label} onboarding questionnaire ({$this->reference})",
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.onboarding-start',
        );
    }
}

