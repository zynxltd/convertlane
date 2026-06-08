@php
    $label = $partnerType === 'advertiser' ? 'Advertiser' : 'Publisher';
@endphp

<x-mail::message>
# Next step: {{ $label }} onboarding

Thanks for applying to **{{ config('app.name') }}**.

**Reference:** {{ $reference }}

## What we need from you

1. Complete the onboarding questionnaire
2. Be ready to provide due diligence documents, including **government-issued photo ID** (passport / driving licence / national ID) and **proof of address** (utility/bank ≤ 3 months).  
   - For companies, we’ll also request incorporation + UBO details.  
   - For individuals (not registered), we’ll verify you personally.

<x-mail::button :url="$questionnaireUrl">
Open onboarding questionnaire
</x-mail::button>

If the button doesn’t work, copy and paste this link:
{{ $questionnaireUrl }}

We’ll review your submission and reply with the document request pack and upload instructions.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

