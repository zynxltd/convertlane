@php
    $type = ($payload['type'] ?? 'publisher') === 'advertiser' ? 'Advertiser' : 'Publisher';
    $entity = match (($payload['entity_type'] ?? 'company')) {
        'sole_trader' => 'Sole trader',
        'individual' => 'Individual (not registered)',
        default => 'Registered company',
    };
@endphp

<x-mail::message>
# Onboarding questionnaire — {{ $type }}

**Reference:** {{ $payload['partner_reference'] ?? '—' }}  
**Contact:** {{ $payload['contact_name'] ?? '—' }}  
**Email:** {{ $payload['contact_email'] ?? '—' }}  
**Entity type:** {{ $entity }}

---

## Basics

- **Website:** {{ $payload['website'] ?? '—' }}
- **Country:** {{ $payload['country'] ?? '—' }}
- **Company name:** {{ $payload['company_name'] ?? '—' }}
- **Company number:** {{ $payload['company_number'] ?? '—' }}

@if ($type === 'Publisher')
## Traffic profile

- **Traffic sources:** {{ $payload['traffic_sources'] ?? '—' }}
- **Promotion channels / properties:** {{ $payload['promo_channels'] ?? '—' }}
- **Top countries:** {{ $payload['top_countries'] ?? '—' }}
- **Estimated monthly volume:** {{ $payload['monthly_volume'] ?? '—' }}
@else
## Product & tracking

- **Vertical:** {{ $payload['vertical'] ?? '—' }}
- **Product description:** {{ $payload['product_description'] ?? '—' }}
- **Landing pages:** {{ $payload['landing_pages'] ?? '—' }}
- **Postback URL / spec:** {{ $payload['postback_url'] ?? '—' }}
@endif

## Notes

{{ $payload['notes'] ?? '—' }}

---

## Next step (DD pack)

Request government-issued photo ID and proof of address (passport / driving licence / national ID + utility/bank ≤ 3 months), plus the standard KYB/KYC + traffic/regulatory evidence appropriate for the partner type.

</x-mail::message>

