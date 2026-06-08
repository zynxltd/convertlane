<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdvertiserEnquiryRequest;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdvertiserEnquiryController extends Controller
{
    public function create(): View
    {
        return view('pages.advertiser-enquiry', [
            'vertical' => request('vertical'),
        ]);
    }

    public function store(StoreAdvertiserEnquiryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        unset($data['website_hp']);

        Contact::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'subject' => 'Advertiser enquiry — '.$data['company'],
            'message' => $data['message'],
        ]);

        return redirect()
            ->route('advertiser.enquiry')
            ->with('success', 'Enquiry received. Our partnerships team will respond within one business day.');
    }
}
