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
    $companyName = filled($questionnaire['company_name'] ?? null)
        ? $questionnaire['company_name']
        : ($questionnaire['contact_name'] ?? '—');
@endphp

<h2 style="{{ $font }} font-size: 20px; line-height: 1.3; color: #0f172a; margin: 0 0 6px; font-weight: 700;">Affiliate / Publisher Agreement</h2>
<p style="{{ $muted }}">{{ $legalName }} · convertlane.co.uk</p>

<h3 style="{{ $subheading }}">Parties</h3>
<p style="{{ $text }}"><strong>Network:</strong> {{ $legalName }}, United Kingdom (“{{ $brand }}”)</p>
<p style="{{ $text }}"><strong>Affiliate:</strong> {{ $companyName }}</p>
@if (filled($questionnaire['company_number'] ?? null))
<p style="{{ $text }}"><strong>Company no.:</strong> {{ $questionnaire['company_number'] }}</p>
@endif
<p style="{{ $text }}"><strong>Entity type:</strong> {{ $entity }}</p>
<p style="{{ $text }}"><strong>Contact:</strong> {{ $questionnaire['contact_name'] ?? '—' }} · {{ $questionnaire['contact_email'] ?? '—' }}</p>
<p style="{{ $text }}"><strong>Country:</strong> {{ $questionnaire['country'] ?? '—' }}</p>
@if (filled($questionnaire['website'] ?? null))
<p style="{{ $text }}"><strong>Website:</strong> {{ $questionnaire['website'] }}</p>
@endif
<p style="{{ $text }}"><strong>Agreement ID:</strong> {{ $agreementId }}</p>
<p style="{{ $text }}"><strong>Reference:</strong> {{ $review->partner_reference }}</p>
<p style="{{ $text }}"><strong>Effective date:</strong> {{ $signedAt->format('j F Y') }}</p>

<h3 style="{{ $subheading }}">Traffic profile (from your questionnaire)</h3>
<p style="{{ $text }}"><strong>Traffic sources:</strong> {{ $questionnaire['traffic_sources'] ?? '—' }}</p>
<p style="{{ $text }}"><strong>Channels:</strong> {{ $questionnaire['promo_channels'] ?? '—' }}</p>
@if (filled($questionnaire['top_countries'] ?? null))
<p style="{{ $text }}"><strong>Top countries:</strong> {{ $questionnaire['top_countries'] }}</p>
@endif
@if (filled($questionnaire['monthly_volume'] ?? null))
<p style="{{ $text }}"><strong>Estimated volume:</strong> {{ $questionnaire['monthly_volume'] }}</p>
@endif

<h3 style="{{ $subheading }}">Key terms</h3>
<ul style="{{ $text }} padding-left: 20px;">
    <li style="margin-bottom: 6px;">Non-exclusive appointment to promote approved offers via the ConvertLane platform.</li>
    <li style="margin-bottom: 6px;">No tracking links until ConvertLane sets your status to <strong>approved</strong>.</li>
    <li style="margin-bottom: 6px;">Promote only with approved links, creatives, and landing pages; comply with UK advertising and privacy law.</li>
    <li style="margin-bottom: 6px;">Clear affiliate disclosures required on all promotional content.</li>
    <li style="margin-bottom: 6px;">Prohibited unless allowed on the offer: incent, brand bidding, bots, cookie stuffing, rebrokering links.</li>
    <li style="margin-bottom: 6px;"><strong>Payment:</strong> Net-30, paid on the 15th for the prior month; £100 / $100 threshold; bank transfer or Wise.</li>
    <li style="margin-bottom: 6px;">Pay approved conversions only, per platform reporting and advertiser validation.</li>
    <li style="margin-bottom: 6px;">Either party: 7 days’ written notice to terminate.</li>
    <li style="margin-bottom: 6px;">Governing law: England and Wales.</li>
</ul>
<p style="{{ $muted }}">Payout rates and cap rules for each offer are confirmed in the platform when offers are assigned to you after approval.</p>
