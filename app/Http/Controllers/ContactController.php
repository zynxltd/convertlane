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

        try {
            $contact = Contact::query()->create($data);
        } catch (\Throwable $e) {
            Log::error('Contact form submission failed', [
                'email' => $request->input('email'),
                'subject' => $request->input('subject'),
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);

            return back()
                ->withInput()
                ->with('error', 'We could not send your message right now. Please try again or email '.BrandContact::email().'.');
        }

        $this->sendContactMail($contact);

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
