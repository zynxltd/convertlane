@props([
    'type' => 'publisher',
    'questionnaire' => [],
    'reference' => '',
])

@php
    $isAdvertiser = $type === 'advertiser';
    $entity = match ($questionnaire['entity_type'] ?? 'company') {
        'sole_trader' => 'Sole trader',
        'individual' => 'Individual',
        default => 'Registered company',
    };
@endphp

<dl class="divide-y divide-slate-200 dark:divide-white/10">
    <div class="grid gap-1 py-3 sm:grid-cols-3 sm:gap-4">
        <dt class="text-sm font-medium text-muted">Reference</dt>
        <dd class="text-sm text-heading sm:col-span-2 font-mono">{{ $reference }}</dd>
    </div>
    <div class="grid gap-1 py-3 sm:grid-cols-3 sm:gap-4">
        <dt class="text-sm font-medium text-muted">Contact</dt>
        <dd class="text-sm text-heading sm:col-span-2">{{ $questionnaire['contact_name'] ?? '—' }} · {{ $questionnaire['contact_email'] ?? '—' }}</dd>
    </div>
    <div class="grid gap-1 py-3 sm:grid-cols-3 sm:gap-4">
        <dt class="text-sm font-medium text-muted">Entity type</dt>
        <dd class="text-sm text-heading sm:col-span-2">{{ $entity }}</dd>
    </div>
    @if (filled($questionnaire['company_name'] ?? null))
        <div class="grid gap-1 py-3 sm:grid-cols-3 sm:gap-4">
            <dt class="text-sm font-medium text-muted">{{ $isAdvertiser ? 'Legal company name' : 'Company / trading name' }}</dt>
            <dd class="text-sm text-heading sm:col-span-2">{{ $questionnaire['company_name'] }}</dd>
        </div>
    @endif
    @if (filled($questionnaire['company_number'] ?? null))
        <div class="grid gap-1 py-3 sm:grid-cols-3 sm:gap-4">
            <dt class="text-sm font-medium text-muted">Company number</dt>
            <dd class="text-sm text-heading sm:col-span-2">{{ $questionnaire['company_number'] }}</dd>
        </div>
    @endif
    <div class="grid gap-1 py-3 sm:grid-cols-3 sm:gap-4">
        <dt class="text-sm font-medium text-muted">Country</dt>
        <dd class="text-sm text-heading sm:col-span-2">{{ $questionnaire['country'] ?? '—' }}</dd>
    </div>
    @if (filled($questionnaire['website'] ?? null))
        <div class="grid gap-1 py-3 sm:grid-cols-3 sm:gap-4">
            <dt class="text-sm font-medium text-muted">Website</dt>
            <dd class="text-sm text-heading sm:col-span-2 break-all">{{ $questionnaire['website'] }}</dd>
        </div>
    @endif

    @if ($isAdvertiser)
        <div class="grid gap-1 py-3 sm:grid-cols-3 sm:gap-4">
            <dt class="text-sm font-medium text-muted">Vertical</dt>
            <dd class="text-sm text-heading sm:col-span-2">{{ $questionnaire['vertical'] ?? '—' }}</dd>
        </div>
        @if (filled($questionnaire['product_description'] ?? null))
            <div class="grid gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-muted">Product</dt>
                <dd class="text-sm text-heading sm:col-span-2">{{ $questionnaire['product_description'] }}</dd>
            </div>
        @endif
        <div class="grid gap-1 py-3 sm:grid-cols-3 sm:gap-4">
            <dt class="text-sm font-medium text-muted">Landing pages</dt>
            <dd class="text-sm text-heading sm:col-span-2 whitespace-pre-wrap break-all">{{ $questionnaire['landing_pages'] ?? '—' }}</dd>
        </div>
        <div class="grid gap-1 py-3 sm:grid-cols-3 sm:gap-4">
            <dt class="text-sm font-medium text-muted">Postback / tracking</dt>
            <dd class="text-sm text-heading sm:col-span-2 break-all">{{ $questionnaire['postback_url'] ?? '—' }}</dd>
        </div>
    @else
        <div class="grid gap-1 py-3 sm:grid-cols-3 sm:gap-4">
            <dt class="text-sm font-medium text-muted">Traffic sources</dt>
            <dd class="text-sm text-heading sm:col-span-2">{{ $questionnaire['traffic_sources'] ?? '—' }}</dd>
        </div>
        <div class="grid gap-1 py-3 sm:grid-cols-3 sm:gap-4">
            <dt class="text-sm font-medium text-muted">Channels</dt>
            <dd class="text-sm text-heading sm:col-span-2">{{ $questionnaire['promo_channels'] ?? '—' }}</dd>
        </div>
        @if (filled($questionnaire['top_countries'] ?? null))
            <div class="grid gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-muted">Top countries</dt>
                <dd class="text-sm text-heading sm:col-span-2">{{ $questionnaire['top_countries'] }}</dd>
            </div>
        @endif
        @if (filled($questionnaire['monthly_volume'] ?? null))
            <div class="grid gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                <dt class="text-sm font-medium text-muted">Estimated volume</dt>
                <dd class="text-sm text-heading sm:col-span-2">{{ $questionnaire['monthly_volume'] }}</dd>
            </div>
        @endif
    @endif

    @if (filled($questionnaire['notes'] ?? null))
        <div class="grid gap-1 py-3 sm:grid-cols-3 sm:gap-4">
            <dt class="text-sm font-medium text-muted">Notes</dt>
            <dd class="text-sm text-heading sm:col-span-2 whitespace-pre-wrap">{{ $questionnaire['notes'] }}</dd>
        </div>
    @endif
</dl>
