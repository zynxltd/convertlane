<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOnboardingQuestionnaireRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $isAdvertiser = $this->routeIs('onboarding.advertiser.store');

        return [
            'partner_reference' => ['nullable', 'string', 'max:50'],
            'contact_email' => ['required', 'email:rfc', 'max:255'],
            'contact_name' => ['required', 'string', 'min:2', 'max:120'],
            'entity_type' => ['required', Rule::in(['company', 'sole_trader', 'individual'])],

            // Basics
            'company_name' => [$isAdvertiser ? 'required' : 'nullable', 'string', 'max:255'],
            'company_number' => ['nullable', 'string', 'max:80'],
            'website' => ['required', 'url', 'max:500'],
            'country' => ['required', 'string', 'size:2', 'regex:/^[A-Z]{2}$/'],

            // Publisher traffic profile
            'traffic_sources' => [$isAdvertiser ? 'nullable' : 'required', 'string', 'max:2000'],
            'promo_channels' => [$isAdvertiser ? 'nullable' : 'required', 'string', 'max:2000'],
            'top_countries' => ['nullable', 'string', 'max:500'],
            'monthly_volume' => ['nullable', 'string', 'max:120'],

            // Advertiser product profile
            'vertical' => [$isAdvertiser ? 'required' : 'nullable', 'string', 'max:120'],
            'product_description' => ['nullable', 'string', 'max:2000'],
            'landing_pages' => [$isAdvertiser ? 'required' : 'nullable', 'string', 'max:2000'],
            'postback_url' => [$isAdvertiser ? 'required' : 'nullable', 'string', 'max:2000'],

            'notes' => ['nullable', 'string', 'max:5000'],
            'confirm_id_required' => ['accepted'],
        ];
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
    }

    public function messages(): array
    {
        return [
            'country.required' => 'Country is required.',
            'confirm_id_required.accepted' => 'You must confirm you can provide government-issued ID and proof of address to proceed.',
        ];
    }
}

