<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Mail\ContactSubmissionMail;
use App\Models\Contact;
use App\Support\BrandContact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function create(): View
    {
        return view('pages.contact');
    }

    public function store(StoreContactRequest $request): RedirectResponse
    {
        $data = $request->safe()->only([
            'name',
            'email',
            'subject',
            'message',
        ]);

        Log::info('Contact form submission received', [
            'email' => $data['email'],
            'subject' => $data['subject'],
            'name' => $data['name'],
            'message_length' => strlen($data['message']),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        try {
            $contact = Contact::query()->create($data);
        } catch (\Throwable $e) {
            Log::error('Contact form submission failed', [
                'email' => $request->input('email'),
                'subject' => $request->input('subject'),
                'ip' => $request->ip(),
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);

            return back()
                ->withInput()
                ->with('error', 'We could not send your message right now. Please try again or email '.BrandContact::email().'.');
        }

        Log::info('Contact form saved', [
            'contact_id' => $contact->id,
            'email' => $contact->email,
            'subject' => $contact->subject,
        ]);

        $mailed = $this->sendContactMail($contact);

        Log::info('Contact form completed', [
            'contact_id' => $contact->id,
            'email' => $contact->email,
            'subject' => $contact->subject,
            'email_sent' => $mailed,
        ]);

        return redirect()
            ->route('contact')
            ->with('success', 'Message sent. We typically respond within one business day.');
    }

    protected function sendContactMail(Contact $contact): bool
    {
        try {
            $mail = (new ContactSubmissionMail($contact))
                ->replyTo($contact->email, $contact->name);

            Mail::to(BrandContact::email())->send($mail);

            Log::info('Contact form email sent', [
                'contact_id' => $contact->id,
                'to' => BrandContact::email(),
                'reply_to' => $contact->email,
            ]);

            return true;
        } catch (\Throwable $e) {
            Log::warning('Contact form email failed', [
                'contact_id' => $contact->id,
                'email' => $contact->email,
                'subject' => $contact->subject,
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);

            return false;
        }
    }
}
