@php
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

<h2 class="text-lg font-semibold text-heading">Affiliate / Publisher Agreement</h2>
<p class="mt-2 text-sm text-muted">{{ $legalName }} · convertlane.co.uk</p>

<section class="mt-6 space-y-3 text-sm text-body">
    <h3 class="font-semibold text-heading">Parties</h3>
    <p><strong>Network:</strong> {{ $legalName }}, United Kingdom (“{{ $brand }}”)</p>
    <p><strong>Affiliate:</strong> {{ $companyName }}</p>
    @if (filled($questionnaire['company_number'] ?? null))
        <p><strong>Company no.:</strong> {{ $questionnaire['company_number'] }}</p>
    @endif
    <p><strong>Entity type:</strong> {{ $entity }}</p>
    <p><strong>Contact:</strong> {{ $questionnaire['contact_name'] ?? '—' }} · {{ $questionnaire['contact_email'] ?? '—' }}</p>
    <p><strong>Country:</strong> {{ $questionnaire['country'] ?? '—' }}</p>
    @if (filled($questionnaire['website'] ?? null))
        <p><strong>Website:</strong> {{ $questionnaire['website'] }}</p>
    @endif
    <p><strong>Agreement ID:</strong> {{ $agreementId }}</p>
    <p><strong>Reference:</strong> {{ $review->partner_reference }}</p>
    <p><strong>Effective date:</strong> {{ now()->format('j F Y') }}</p>
</section>

<section class="mt-6 space-y-2 text-sm text-body">
    <h3 class="font-semibold text-heading">Traffic profile (from your questionnaire)</h3>
    <p><strong>Traffic sources:</strong> {{ $questionnaire['traffic_sources'] ?? '—' }}</p>
    <p><strong>Channels:</strong> {{ $questionnaire['promo_channels'] ?? '—' }}</p>
    @if (filled($questionnaire['top_countries'] ?? null))
        <p><strong>Top countries:</strong> {{ $questionnaire['top_countries'] }}</p>
    @endif
    @if (filled($questionnaire['monthly_volume'] ?? null))
        <p><strong>Estimated volume:</strong> {{ $questionnaire['monthly_volume'] }}</p>
    @endif
</section>

<section class="mt-6 space-y-2 text-sm text-body">
    <h3 class="font-semibold text-heading">Key terms</h3>
    <ul class="list-disc space-y-1 pl-5">
        <li>Non-exclusive appointment to promote approved offers via Offer18 (convertlane.offer18.com).</li>
        <li>No tracking links until ConvertLane sets your status to <strong>approved</strong>.</li>
        <li>Promote only with approved links, creatives, and landing pages; comply with UK advertising and privacy law.</li>
        <li>Clear affiliate disclosures required on all promotional content.</li>
        <li>Prohibited unless IO allows: incent, brand bidding, bots, cookie stuffing, rebrokering links.</li>
        <li><strong>Payment:</strong> Net-30, paid on the 15th for the prior month; £100 / $100 threshold; bank transfer or Wise.</li>
        <li>Pay approved conversions only, per Offer18 and advertiser validation.</li>
        <li>Either party: 7 days’ written notice to terminate.</li>
        <li>Governing law: England and Wales.</li>
    </ul>
    <p class="mt-2 text-muted">Payout rates and cap rules for each offer are confirmed in the platform when offers are assigned to you after approval.</p>
</section>
