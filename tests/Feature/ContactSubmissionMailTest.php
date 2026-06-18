<?php

namespace Tests\Feature;

use App\Mail\ContactSubmissionMail;
use App\Support\BrandContact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactSubmissionMailTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_sends_postmark_mail_to_partners(): void
    {
        Mail::fake();

        $this->post(route('contact.store'), [
            'name' => 'Alex Smith',
            'email' => 'alex@example.com',
            'subject' => 'Partnerships',
            'message' => 'I would like to discuss a partnership opportunity.',
        ])->assertRedirect(route('contact'))
            ->assertSessionHas('success');

        Mail::assertSent(ContactSubmissionMail::class, function (ContactSubmissionMail $mail) {
            return $mail->hasTo(BrandContact::email())
                && $mail->hasReplyTo('alex@example.com', 'Alex Smith')
                && $mail->contact->name === 'Alex Smith'
                && $mail->contact->subject === 'Partnerships';
        });
    }

    public function test_contact_form_mail_failure_still_succeeds_when_message_is_persisted(): void
    {
        Mail::shouldReceive('to')->once()->andReturnSelf();
        Mail::shouldReceive('send')->once()->andThrow(new \RuntimeException('Postmark failure'));

        $this->post(route('contact.store'), [
            'name' => 'Alex Smith',
            'email' => 'alex@example.com',
            'subject' => 'Partnerships',
            'message' => 'I would like to discuss a partnership opportunity.',
        ])->assertRedirect(route('contact'))
            ->assertSessionHas('success')
            ->assertSessionMissing('error');

        $this->assertDatabaseHas('contacts', [
            'email' => 'alex@example.com',
            'subject' => 'Partnerships',
        ]);
    }
}
