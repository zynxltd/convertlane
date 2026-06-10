@php
    $isAdvertiser = $agreement->type === 'advertiser';
    $type = $isAdvertiser ? 'Advertiser' : 'Affiliate';
    $questionnaire = $agreement->questionnaire_snapshot ?? [];
    $agreementId = ($isAdvertiser ? 'CL-ADV' : 'CL-PUB').'-'.str_pad((string) $agreement->dueDiligenceReview?->application_id, 5, '0', STR_PAD_LEFT);
    $isInternal = $audience === 'internal';
@endphp

<x-mail::message>
@if ($isInternal)
# Signed {{ $type }} agreement

A partner has digitally signed and submitted their agreement for approval.

**Reference:** {{ $agreement->partner_reference }}  
**Agreement ID:** {{ $agreementId }}  
**Signed by:** {{ $agreement->signer_name }}{{ $agreement->signer_title ? ' · '.$agreement->signer_title : '' }}  
**Email:** {{ $questionnaire['contact_email'] ?? '—' }}  
**Submitted:** {{ $agreement->submitted_at->format('j M Y H:i') }} UTC  
@if ($agreement->billing_model)
**Billing:** {{ ucfirst($agreement->billing_model) }}  
@endif
**IP:** {{ $agreement->signed_ip ?? '—' }}

<x-mail::button :url="url('/compliance/reviews/'.$agreement->due_diligence_review_id.'?key='.config('compliance.internal_access_key'))">
Open compliance review
</x-mail::button>
@else
# Your signed {{ $type }} Agreement

Thank you for submitting your agreement to {{ config('brand.name') }}.

**Reference:** {{ $agreement->partner_reference }}  
**Agreement ID:** {{ $agreementId }}  
**Submitted:** {{ $agreement->submitted_at->format('j M Y H:i') }} UTC  

We will review your application and contact you if we need anything further. You will hear from us within a few business days.

@if ($isAdvertiser)
@if ($agreement->billing_model === 'prepay')
**Billing selected:** Prepay — we will send funding instructions before your campaign goes live.
@elseif ($agreement->billing_model === 'postpay')
**Billing selected:** Postpay — our team will confirm credit terms before traffic starts.
@endif
@else
Once approved, you will receive offer details and Platform access.
@endif
@endif

---

## Agreement copy

<div style="font-family: ui-sans-serif, system-ui, sans-serif; font-size: 14px; line-height: 1.5; color: #334155;">
{!! $agreement->agreement_body !!}
</div>

@if (! $isInternal)
If anything in this copy looks incorrect, reply to this email or contact {{ config('brand.support_email') }}.
@endif

Thanks,<br>
{{ config('brand.name') }}
</x-mail::message>
