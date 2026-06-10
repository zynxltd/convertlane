@php
    $font = 'font-family: Arial, Helvetica, sans-serif;';
    $text = $font.' font-size: 14px; line-height: 1.55; color: #334155; margin: 0 0 10px;';
    $muted = $font.' font-size: 13px; line-height: 1.5; color: #64748b; margin: 0 0 10px;';
    $subheading = $font.' font-size: 14px; line-height: 1.4; color: #0f172a; margin: 18px 0 8px; font-weight: 700;';
    $legalName = config('brand.legal_name');
    $brand = config('brand.name');
    $entity = match ($questionnaire['entity_type'] ?? 'company') {
        'sole_trader' => 'Sole trader',
        'individual' => 'Individual',
        default => 'Registered company',
    };
@endphp

<h2 style="{{ $font }} font-size: 20px; line-height: 1.3; color: #0f172a; margin: 0 0 6px; font-weight: 700;">Advertiser Agreement</h2>
<p style="{{ $muted }}">{{ $legalName }} · convertlane.co.uk</p>

<h3 style="{{ $subheading }}">Parties</h3>
<p style="{{ $text }}"><strong>Network:</strong> {{ $legalName }}, United Kingdom (“{{ $brand }}”)</p>
<p style="{{ $text }}"><strong>Advertiser:</strong> {{ $questionnaire['company_name'] ?? '—' }}</p>
@if (filled($questionnaire['company_number'] ?? null))
<p style="{{ $text }}"><strong>Company no.:</strong> {{ $questionnaire['company_number'] }}</p>
@endif
<p style="{{ $text }}"><strong>Entity type:</strong> {{ $entity }}</p>
<p style="{{ $text }}"><strong>Authorised signatory:</strong> {{ $questionnaire['contact_name'] ?? '—' }} · {{ $questionnaire['contact_email'] ?? '—' }}</p>
<p style="{{ $text }}"><strong>Country:</strong> {{ $questionnaire['country'] ?? '—' }}</p>
<p style="{{ $text }}"><strong>Website:</strong> {{ $questionnaire['website'] ?? '—' }}</p>
<p style="{{ $text }}"><strong>Agreement ID:</strong> {{ $agreementId }}</p>
<p style="{{ $text }}"><strong>Reference:</strong> {{ $review->partner_reference }}</p>
<p style="{{ $text }}"><strong>Effective date:</strong> {{ $signedAt->format('j F Y') }}</p>

<h3 style="{{ $subheading }}">Offer profile (from your questionnaire)</h3>
<p style="{{ $text }}"><strong>Vertical:</strong> {{ $questionnaire['vertical'] ?? '—' }}</p>
@if (filled($questionnaire['product_description'] ?? null))
<p style="{{ $text }}"><strong>Product:</strong> {{ $questionnaire['product_description'] }}</p>
@endif
<p style="{{ $text }}"><strong>Landing pages:</strong> {{ $questionnaire['landing_pages'] ?? '—' }}</p>
<p style="{{ $text }}"><strong>Postback / tracking:</strong> {{ $questionnaire['postback_url'] ?? '—' }}</p>

<h3 style="{{ $subheading }}">Key terms</h3>
<ul style="{{ $text }} padding-left: 20px;">
    <li style="margin-bottom: 6px;">{{ $brand }} distributes approved offers to vetted affiliates via the ConvertLane platform.</li>
    <li style="margin-bottom: 6px;">You provide accurate offer terms, landing pages, postbacks, and validation rules.</li>
    <li style="margin-bottom: 6px;">You maintain valid licences for regulated products (FCA, credit broking, etc. where applicable).</li>
    <li style="margin-bottom: 6px;"><strong>Finance vertical:</strong> You confirm compliance with UK financial promotion rules on your landing pages.</li>
    <li style="margin-bottom: 6px;">The platform is the system of record for clicks, conversions, and caps.</li>
    <li style="margin-bottom: 6px;">Either party: 14 days’ written notice to terminate.</li>
    <li style="margin-bottom: 6px;">Governing law: England and Wales.</li>
</ul>
<p style="{{ $muted }}">Campaign caps, payout model, and network fee are set in a separate Insertion Order (IO) per offer.</p>
