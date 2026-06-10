@php
    $legalName = config('brand.legal_name');
    $brand = config('brand.name');
    $entity = match ($questionnaire['entity_type'] ?? 'company') {
        'sole_trader' => 'Sole trader',
        'individual' => 'Individual',
        default => 'Registered company',
    };
@endphp

<h2 class="text-lg font-semibold text-heading">Advertiser Agreement</h2>
<p class="mt-2 text-sm text-muted">{{ $legalName }} · convertlane.co.uk</p>

<section class="mt-6 space-y-3 text-sm text-body">
    <h3 class="font-semibold text-heading">Parties</h3>
    <p><strong>Network:</strong> {{ $legalName }}, United Kingdom (“{{ $brand }}”)</p>
    <p><strong>Advertiser:</strong> {{ $questionnaire['company_name'] ?? '—' }}</p>
    @if (filled($questionnaire['company_number'] ?? null))
        <p><strong>Company no.:</strong> {{ $questionnaire['company_number'] }}</p>
    @endif
    <p><strong>Entity type:</strong> {{ $entity }}</p>
    <p><strong>Authorised signatory:</strong> {{ $questionnaire['contact_name'] ?? '—' }} · {{ $questionnaire['contact_email'] ?? '—' }}</p>
    <p><strong>Country:</strong> {{ $questionnaire['country'] ?? '—' }}</p>
    <p><strong>Website:</strong> {{ $questionnaire['website'] ?? '—' }}</p>
    <p><strong>Agreement ID:</strong> {{ $agreementId }}</p>
    <p><strong>Reference:</strong> {{ $review->partner_reference }}</p>
    <p><strong>Effective date:</strong> {{ now()->format('j F Y') }}</p>
</section>

<section class="mt-6 space-y-2 text-sm text-body">
    <h3 class="font-semibold text-heading">Offer profile (from your questionnaire)</h3>
    <p><strong>Vertical:</strong> {{ $questionnaire['vertical'] ?? '—' }}</p>
    @if (filled($questionnaire['product_description'] ?? null))
        <p><strong>Product:</strong> {{ $questionnaire['product_description'] }}</p>
    @endif
    <p><strong>Landing pages:</strong> {{ $questionnaire['landing_pages'] ?? '—' }}</p>
    <p><strong>Postback / tracking:</strong> {{ $questionnaire['postback_url'] ?? '—' }}</p>
</section>

<section class="mt-6 space-y-2 text-sm text-body">
    <h3 class="font-semibold text-heading">Key terms</h3>
    <ul class="list-disc space-y-1 pl-5">
        <li>{{ $brand }} distributes approved offers to vetted affiliates via Offer18.</li>
        <li>You provide accurate offer terms, landing pages, postbacks, and validation rules.</li>
        <li>You maintain valid licences for regulated products (FCA, credit broking, etc. where applicable).</li>
        <li><strong>Finance vertical:</strong> You confirm compliance with UK financial promotion rules on your landing pages.</li>
        <li>Offer18 is the system of record for clicks, conversions, and caps.</li>
        <li>Validate conversions in good faith within the SLA in each IO.</li>
        <li>Either party: 14 days’ written notice to terminate.</li>
        <li>Governing law: England and Wales.</li>
    </ul>
    <p class="mt-2 text-muted">Campaign caps, payout model, and network fee are set in a separate Insertion Order (IO) per offer.</p>
</section>
