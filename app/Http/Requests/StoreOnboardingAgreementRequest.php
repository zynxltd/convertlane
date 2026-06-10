<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreOnboardingAgreementRequest extends FormRequest
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
        $isAdvertiser = $this->routeIs('onboarding.advertiser.agreement.store');

        return [
            'partner_reference' => ['required', 'string', 'max:50'],
            'contact_email' => ['required', 'email:rfc', 'max:255'],
            'signer_name' => ['required', 'string', 'min:2', 'max:120'],
            'signer_title' => ['nullable', 'string', 'max:120'],
            'signature_data' => ['required', 'string', 'regex:/^data:image\/png;base64,[A-Za-z0-9+\/=]+$/'],
            'billing_model' => [$isAdvertiser ? 'required' : 'nullable', Rule::in(['prepay', 'postpay'])],
            'accept_agreement' => ['accepted'],
            'accept_terms' => ['accepted'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'signature_data.required' => 'Please draw your signature before submitting.',
            'signature_data.regex' => 'Your signature could not be saved. Please sign again.',
            'accept_agreement.accepted' => 'You must accept the agreement to continue.',
            'accept_terms.accepted' => 'You must accept the terms of service to continue.',
            'billing_model.required' => 'Please choose prepay or postpay billing.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $email = (string) $this->input('contact_email', '');
        $reference = (string) $this->input('partner_reference', '');
        $isAdvertiser = $this->routeIs('onboarding.advertiser.agreement.store');

        $route = $isAdvertiser ? 'onboarding.advertiser.agreement' : 'onboarding.publisher.agreement';

        throw new HttpResponseException(
            redirect()
                ->route($route, array_filter([
                    'email' => $email,
                    'ref' => $reference,
                ]))
                ->withInput()
                ->withErrors($validator)
        );
    }
}
