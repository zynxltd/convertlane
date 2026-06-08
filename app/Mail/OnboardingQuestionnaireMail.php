<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Internal mail to partners@ with applicant questionnaire.
 *
 * @param array<string, mixed> $payload
 */
class OnboardingQuestionnaireMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  array<string, mixed>  $payload
     */
    public function __construct(
        public array $payload,
    ) {}

    public function envelope(): Envelope
    {
        $type = ($this->payload['type'] ?? 'publisher') === 'advertiser' ? 'Advertiser' : 'Publisher';
        $ref = (string) ($this->payload['partner_reference'] ?? '');
        $email = (string) ($this->payload['contact_email'] ?? '');

        $subject = trim("Onboarding questionnaire — {$type}".($ref !== '' ? " ({$ref})" : '').($email !== '' ? " — {$email}" : ''));

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.onboarding-questionnaire',
        );
    }
}

