<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdvertiserEnquiryRequest extends FormRequest
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
        return [
            'name' => ['required', 'string', 'min:2', 'max:200', 'regex:/^[\pL\s\'\-\.]+$/u'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'company' => ['required', 'string', 'min:2', 'max:200'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
            'website_hp' => ['nullable', 'string', 'max:0'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.regex' => 'Name may only contain letters, spaces, hyphens, and apostrophes.',
            'company.required' => 'Please enter your company or brand name.',
            'message.min' => 'Please share a few details about the offer you want to launch.',
            'website_hp.max' => 'Your submission could not be processed.',
        ];
    }

    public function attributes(): array
    {
        return [
            'website_hp' => 'form',
        ];
    }
}
