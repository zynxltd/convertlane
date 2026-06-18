<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

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
        ];
    }

    public function messages(): array
    {
        return [
            'name.regex' => 'Name may only contain letters, spaces, hyphens, and apostrophes.',
            'email.email' => 'Please enter a valid email address.',
            'subject.in' => 'Please choose a subject from the list.',
            'message.min' => 'Please enter at least 10 characters in your message.',
        ];
    }

    public function attributes(): array
    {
        return [];
    }

    protected function failedValidation(Validator $validator): void
    {
        Log::info('Contact form validation failed', [
            'email' => $this->input('email'),
            'subject' => $this->input('subject'),
            'errors' => $validator->errors()->keys(),
            'ip' => $this->ip(),
            'user_agent' => $this->userAgent(),
        ]);

        throw new ValidationException($validator);
    }
}
