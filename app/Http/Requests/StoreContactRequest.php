<?php

namespace App\Http\Requests;

use App\Rules\Turnstile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreContactRequest extends FormRequest
{
    private const SUBJECTS = [
        'Partnerships',
        'Publisher support',
        'Advertiser support',
        'Compliance',
        'Billing & payouts',
        'Technical / tracking',
        'Other',
    ];

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:200', 'regex:/^[\pL\s\'\-\.]+$/u'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'subject' => ['required', 'string', Rule::in(self::SUBJECTS)],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
            'website_hp' => ['nullable', 'string', 'max:0'],
            'cf-turnstile-response' => [
                Rule::requiredIf(fn () => Turnstile::enabled()),
                'string',
                new Turnstile,
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.regex' => 'Name may only contain letters, spaces, hyphens, and apostrophes.',
            'email.email' => 'Please enter a valid email address.',
            'subject.in' => 'Please choose a subject from the list.',
            'message.min' => 'Please enter at least 10 characters in your message.',
            'website_hp.max' => 'Your submission could not be processed.',
            'cf-turnstile-response.required' => 'Please complete the security check.',
        ];
    }

    public function attributes(): array
    {
        return [
            'website_hp' => 'form',
        ];
    }
}
