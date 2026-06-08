<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;
use App\Support\BrandContact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function create(): View
    {
        return view('pages.contact');
    }

    public function store(StoreContactRequest $request): RedirectResponse
    {
        try {
            Contact::query()->create($request->safe()->only([
                'name',
                'email',
                'subject',
                'message',
            ]));
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

        return redirect()
            ->route('contact')
            ->with('success', 'Message sent. We typically respond within one business day.');
    }
}
