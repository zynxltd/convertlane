<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreApplicationRequest extends FormRequest
{
    private const VOLUME_RANGES = ['< £5k', '£5k – £25k', '£25k – £100k', '£100k+'];

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $website = $this->input('website');
        if (filled($website) && ! preg_match('/^https?:\/\//i', (string) $website)) {
            $this->merge(['website' => 'https://'.ltrim((string) $website, '/')]);
        }

        if ($this->filled('country')) {
            $this->merge(['country' => strtoupper((string) $this->input('country'))]);
        }

        if ($this->filled('incorporation_country')) {
            $this->merge(['incorporation_country' => strtoupper((string) $this->input('incorporation_country'))]);
        }
    }

    public function rules(): array
    {
        return [
            'type' => ['required', Rule::in(['publisher', 'advertiser'])],
            'first_name' => ['required', 'string', 'min:2', 'max:100', 'regex:/^[\pL\s\'\-\.]+$/u'],
            'last_name' => ['required', 'string', 'min:2', 'max:100', 'regex:/^[\pL\s\'\-\.]+$/u'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'company' => ['required', 'string', 'min:2', 'max:255'],
            'company_number' => ['required', 'string', 'min:2', 'max:50'],
            'website' => ['required', 'url', 'max:500'],
            'country' => ['required', 'string', 'size:2', 'regex:/^[A-Z]{2}$/'],
            'incorporation_country' => ['nullable', 'string', 'size:2', 'regex:/^[A-Z]{2}$/'],
            'incorporated_at' => ['nullable', 'date', 'before_or_equal:today'],
            'traffic_sources' => [
                Rule::requiredIf(fn () => $this->input('type') === 'publisher'),
                'nullable',
                'string',
                'min:10',
                'max:2000',
            ],
            'monthly_volume' => ['required', 'string', Rule::in(self::VOLUME_RANGES)],
            'message' => ['nullable', 'string', 'max:5000'],
            'terms' => ['accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => 'Please choose whether you are applying as a publisher or advertiser.',
            'type.in' => 'Application type must be publisher or advertiser.',
            'first_name.regex' => 'First name may only contain letters, spaces, hyphens, and apostrophes.',
            'last_name.regex' => 'Last name may only contain letters, spaces, hyphens, and apostrophes.',
            'email.email' => 'Please enter a valid business email address.',
            'company_number.required' => 'Company registration number is required.',
            'website.required' => 'Company website is required.',
            'website.url' => 'Please enter a valid website URL (e.g. https://example.com).',
            'country.required' => 'Please select your company\'s registered country.',
            'country.regex' => 'Country must be a valid two-letter code.',
            'traffic_sources.required_if' => 'Please describe your traffic sources for publisher applications.',
            'traffic_sources.min' => 'Please provide more detail about your traffic sources (at least 10 characters).',
            'monthly_volume.required' => 'Please select an estimated monthly volume range.',
            'monthly_volume.in' => 'Please select a valid volume range.',
            'terms.accepted' => 'You must accept the terms and privacy policy.',
        ];
    }

    public function attributes(): array
    {
        return [
            'first_name' => 'first name',
            'last_name' => 'last name',
            'company_number' => 'company registration number',
            'traffic_sources' => 'traffic sources',
            'monthly_volume' => 'estimated monthly volume',
        ];
    }
}
