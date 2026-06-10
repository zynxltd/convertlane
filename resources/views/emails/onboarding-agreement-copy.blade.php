@php
    $isAdvertiser = $agreement->type === 'advertiser';
    $type = $isAdvertiser ? 'Advertiser' : 'Affiliate';
    $questionnaire = $agreement->questionnaire_snapshot ?? [];
    $agreementId = ($isAdvertiser ? 'CL-ADV' : 'CL-PUB').'-'.str_pad((string) $agreement->dueDiligenceReview?->application_id, 5, '0', STR_PAD_LEFT);
    $isInternal = $audience === 'internal';
    $font = 'font-family: Arial, Helvetica, sans-serif;';
    $text = $font.' font-size: 14px; line-height: 1.55; color: #334155; margin: 0 0 10px;';
    $heading = $font.' font-size: 22px; line-height: 1.3; color: #0f172a; margin: 0 0 16px; font-weight: 700;';
    $section = $font.' font-size: 16px; line-height: 1.4; color: #0f172a; margin: 28px 0 12px; font-weight: 700;';
@endphp

@component('emails.layouts.raw-html')
@slot('content')
    @if ($isInternal)
        <h1 style="{{ $heading }}">Signed {{ $type }} agreement</h1>
        <p style="{{ $text }}">A partner has digitally signed and submitted their agreement for approval.</p>
        <p style="{{ $text }}"><strong>Reference:</strong> {{ $agreement->partner_reference }}<br>
        <strong>Agreement ID:</strong> {{ $agreementId }}<br>
        <strong>Signed by:</strong> {{ $agreement->signer_name }}{{ $agreement->signer_title ? ' · '.$agreement->signer_title : '' }}<br>
        <strong>Email:</strong> {{ $questionnaire['contact_email'] ?? '—' }}<br>
        <strong>Submitted:</strong> {{ $agreement->submitted_at->format('j M Y H:i') }} UTC<br>
        @if ($agreement->billing_model)
        <strong>Billing:</strong> {{ ucfirst($agreement->billing_model) }}<br>
        @endif
        <strong>IP:</strong> {{ $agreement->signed_ip ?? '—' }}</p>
        <p style="margin: 20px 0;">
            <a href="{{ url('/compliance/reviews/'.$agreement->due_diligence_review_id.'?key='.config('compliance.internal_access_key')) }}" style="display: inline-block; background-color: #0891b2; color: #ffffff; text-decoration: none; font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-weight: 700; padding: 12px 18px; border-radius: 8px;">
                Open compliance review
            </a>
        </p>
    @else
        <h1 style="{{ $heading }}">Your signed {{ $type }} Agreement</h1>
        <p style="{{ $text }}">Thank you for submitting your agreement to {{ config('brand.name') }}.</p>
        <p style="{{ $text }}"><strong>Reference:</strong> {{ $agreement->partner_reference }}<br>
        <strong>Agreement ID:</strong> {{ $agreementId }}<br>
        <strong>Submitted:</strong> {{ $agreement->submitted_at->format('j M Y H:i') }} UTC</p>
        <p style="{{ $text }}">We will review your application and contact you if we need anything further. You will hear from us within a few business days.</p>
        @if ($isAdvertiser)
            @if ($agreement->billing_model === 'prepay')
            <p style="{{ $text }}"><strong>Billing selected:</strong> Prepay — we will send funding instructions before your campaign goes live.</p>
            @elseif ($agreement->billing_model === 'postpay')
            <p style="{{ $text }}"><strong>Billing selected:</strong> Postpay — our team will confirm credit terms before traffic starts.</p>
            @endif
            <p style="{{ $text }}">Once approved, you will receive offer IOs and Platform access.</p>
        @else
            <p style="{{ $text }}">Once approved, you will receive Platform access.</p>
        @endif
    @endif

    <h2 style="{{ $section }}">Agreement copy</h2>
    <div style="padding: 20px; border: 1px solid #e2e8f0; background-color: #f8fafc;">
        {!! $emailAgreementBody !!}
        @include('onboarding.agreements.email.signature-block', [
            'type' => $agreement->type,
            'signerName' => $agreement->signer_name,
            'signerTitle' => $agreement->signer_title,
            'signatureImage' => $agreement->signature_image,
            'signedAt' => $agreement->submitted_at,
            'embedSignature' => true,
        ])
    </div>

    @if (! $isInternal)
        <p style="{{ $text }} margin-top: 20px;">If anything in this copy looks incorrect, reply to this email or contact {{ config('brand.support_email') }}.</p>
    @endif

    <p style="{{ $text }} margin-top: 24px;">Thanks,<br>{{ config('app.name') }}</p>
@endslot
@endcomponent
