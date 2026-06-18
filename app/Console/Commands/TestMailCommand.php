<?php

namespace App\Console\Commands;

use App\Mail\ContactSubmissionMail;
use App\Models\Contact;
use App\Support\BrandContact;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestMailCommand extends Command
{
    protected $signature = 'mail:test
                            {--to= : Recipient (defaults to brand contact email)}
                            {--contact : Send a sample contact form notification}';

    protected $description = 'Verify mail configuration and send a test message via Postmark';

    public function handle(): int
    {
        $mailer = (string) config('mail.default');
        $from = (string) config('mail.from.address');
        $to = (string) ($this->option('to') ?: BrandContact::email());
        $postmarkKey = config('services.postmark.key');

        $this->table(['Setting', 'Value'], [
            ['MAIL_MAILER', $mailer],
            ['MAIL_FROM_ADDRESS', $from],
            ['Recipient', $to],
            ['POSTMARK_API_KEY', filled($postmarkKey) ? 'set ('.strlen((string) $postmarkKey).' chars)' : 'MISSING'],
        ]);

        if ($mailer === 'postmark' && blank($postmarkKey)) {
            $this->error('POSTMARK_API_KEY is not set. Add it to .env and run: php artisan config:cache');

            return self::FAILURE;
        }

        try {
            if ($this->option('contact')) {
                $contact = new Contact([
                    'name' => 'Mail Test',
                    'email' => 'test@example.com',
                    'subject' => 'Test',
                    'message' => 'This is a contact form mail test from php artisan mail:test --contact',
                ]);
                $contact->id = 0;

                Mail::to($to)->send(
                    (new ContactSubmissionMail($contact))->replyTo('test@example.com', 'Mail Test')
                );
            } else {
                Mail::raw('ConvertLane mail:test — if you received this, Postmark is working.', function ($message) use ($to) {
                    $message->to($to)->subject('ConvertLane mail test');
                });
            }

            $this->info('Test email sent to '.$to.'. Check Postmark activity and the inbox.');

            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->error('Failed to send: '.$e->getMessage());

            return self::FAILURE;
        }
    }
}
