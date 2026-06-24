<x-layouts.app
    title="Performance Affiliate Network"
    description="ConvertLane connects advertisers with vetted publishers. CPA, CPL, and CPS programmes with manual review, signed IOs, and net-30 payouts."
    :canonical="route('home')"
>
    @push('head')
        <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => config('brand.name'),
            'url' => config('brand.url'),
            'description' => config('brand.description'),
            'publisher' => [
                '@type' => 'Organization',
                'name' => config('brand.name'),
                'url' => config('brand.url'),
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>
    @endpush

    <x-home-hero />

    <x-stats-bar />

    <section class="border-y border-subtle-5 bg-slate-50 py-20 lg:py-28 dark:bg-surface-950">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="eyebrow mx-auto">How it works</p>
                <h2 class="section-heading mt-4">A clear path from application to results</h2>
                <p class="section-sub mx-auto">Every partner is reviewed before they go live. Your account team handles setup, and payouts run on a schedule you can plan around.</p>
            </div>
            <div class="mt-16 grid gap-8 md:grid-cols-3">
                @foreach ([
                    ['title' => 'Apply & get approved', 'desc' => 'We verify your business, traffic or product fit, and compliance requirements. Most reviews complete in 5–10 business days.', 'step' => '01'],
                    ['title' => 'Go live with support', 'desc' => 'Your account manager configures tracking, caps, and creatives so your programme runs exactly as agreed.', 'step' => '02'],
                    ['title' => 'Get paid on schedule', 'desc' => 'Net-30 payouts on the 15th, reconciled to approved performance, with no surprises at month-end.', 'step' => '03'],
                ] as $item)
                    <article class="rounded-2xl border border-subtle bg-elevated p-8 shadow-lg">
                        <span class="font-mono text-sm font-bold text-brand-500">{{ $item['step'] }}</span>
                        <h3 class="mt-4 font-display text-xl font-semibold text-heading">{{ $item['title'] }}</h3>
                        <p class="mt-3 text-sm leading-relaxed text-muted">{{ $item['desc'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="border-y border-subtle-5 py-20 lg:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <p class="eyebrow mx-auto">Account management</p>
                <h2 class="section-heading mt-4">Hands-on support from onboarding to payout</h2>
                <p class="section-sub mx-auto">
                    Every advertiser and publisher account is managed by a dedicated team that handles offer setup, performance reviews, and escalations in one place.
                </p>
            </div>
            <div class="mt-14 grid gap-6 md:grid-cols-3">
                @foreach ([
                    [
                        'title' => 'Offer setup & optimisation',
                        'desc' => 'Account managers configure programmes, adjust caps and geos, and recommend publisher matches aligned to your targets.',
                        'icon' => 'lane',
                    ],
                    [
                        'title' => 'Performance reviews',
                        'desc' => 'Scheduled check-ins on clicks, conversions, EPC, and quality, so you know what is working before month-end.',
                        'icon' => 'chart',
                    ],
                    [
                        'title' => 'Escalation & finance',
                        'desc' => 'Compliance, fraud, and billing queries routed to the right specialists. Payout questions answered against approved stats.',
                        'icon' => 'shield',
                    ],
                ] as $item)
                    <article class="rounded-2xl border border-subtle bg-elevated p-8 shadow-lg">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl border border-brand-500/25 bg-brand-500/10 text-brand-600 dark:text-brand-300">
                            @if ($item['icon'] === 'lane')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" d="M7 20V8M12 20V4M17 20V12"/></svg>
                            @elseif ($item['icon'] === 'chart')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 18h16M7 16l3-6 4 3 5-9"/></svg>
                            @else
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                            @endif
                        </div>
                        <h3 class="mt-5 font-display text-xl font-semibold text-heading">{{ $item['title'] }}</h3>
                        <p class="mt-3 text-sm leading-relaxed text-muted">{{ $item['desc'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="border-y border-subtle-5 bg-slate-50 py-20 lg:py-28 dark:bg-transparent">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="eyebrow">Verticals</p>
                    <h2 class="section-heading mt-4">Where we operate</h2>
                    <p class="section-sub">Specialist teams per vertical, not generalists guessing at compliance.</p>
                </div>
                <a href="{{ route('offers') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-brand-400 hover:text-brand-300">
                    Browse live offers
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
            </div>
            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach (config('brand.verticals') as $vertical)
                    <a
                        href="{{ route('offers', ['vertical' => $vertical['slug']]) }}"
                        class="group flex flex-col rounded-2xl border border-subtle bg-elevated p-6 shadow-lg card-lift transition hover:border-brand-500/30"
                    >
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl border border-brand-500/25 bg-brand-500/10 text-brand-600 transition group-hover:bg-brand-500/20 dark:text-brand-300">
                            <x-vertical-icon :icon="$vertical['icon']" />
                        </div>
                        <h3 class="mt-4 font-display text-lg font-semibold text-heading">{{ $vertical['name'] }}</h3>
                        <p class="mt-2 flex-1 text-sm leading-relaxed text-muted">{{ $vertical['description'] }}</p>
                        <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-brand-600 dark:text-brand-400">
                            View vertical
                            <svg class="h-4 w-4 transition group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <x-faq :items="[
        ['q' => 'How is performance tracked?', 'a' => 'We use a dedicated tracking and reporting setup for clicks, conversions, and caps. Publishers receive panel access only after compliance approval and a signed IO.'],
        ['q' => 'How fast are payouts?', 'a' => 'Net-30 on the 15th for the prior month. Minimum threshold £100 / $100 equivalent.'],
        ['q' => 'Which traffic types do you accept?', 'a' => 'SEO, content, email (opt-in), social, native, and paid, per offer IO. Incentivised and brand bidding require explicit approval.'],
        ['q' => 'How long does onboarding take?', 'a' => '5–10 business days once your document pack is complete. Incomplete applications are closed after 7 days.'],
    ]" />

    <x-cta-banner />
</x-layouts.app>
