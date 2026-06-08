<x-layouts.app
    title="For Publishers & Affiliates"
    description="Monetise your traffic with CPA offers. Net-30 payouts, transparent reporting, and a dedicated account manager at ConvertLane."
>
    <x-page-hero eyebrow="For publishers">
        <x-slot:title>Monetise traffic with <span class="text-gradient-hero">premium offers</span></x-slot:title>
        <x-slot:subtitle>Competitive payouts, reliable tracking, and an account manager who knows your vertical — not a generic inbox.</x-slot:subtitle>
        <x-slot:actions>
            <a href="{{ route('offers') }}" class="btn-primary">Browse live offers</a>
            <a href="{{ route('apply') }}?type=publisher" class="btn-secondary">Apply as publisher</a>
        </x-slot:actions>
    </x-page-hero>

    <x-stats-bar />

    <x-image-split
        page="publishers"
        alt="ConvertLane publisher partnerships meeting"
        eyebrow="Publisher partnerships"
    >
        <h2 class="section-heading mt-4">A network that pays on schedule</h2>
        <p class="section-sub">
            We reconcile every payout run against approved conversion data. Invalid conversions and chargebacks are deducted transparently — not buried in a support ticket.
        </p>
        <ul class="mt-8 space-y-3 text-left text-sm text-body">
            <li class="flex gap-3">
                <span class="mt-0.5 text-brand-500">✓</span>
                Net-30 on the 15th
            </li>
            <li class="flex gap-3">
                <span class="mt-0.5 text-brand-500">✓</span>
                Sub-ID reporting and postback logs on request
            </li>
            <li class="flex gap-3">
                <span class="mt-0.5 text-brand-500">✓</span>
                30-day probation with weekly quality reviews
            </li>
        </ul>
    </x-image-split>

    <section class="border-y border-subtle-5 bg-slate-100/60 py-16 dark:bg-elevated-muted/60 lg:py-20">
        <div class="mx-auto max-w-3xl px-4 text-center sm:px-6 lg:px-8">
            <p class="eyebrow mx-auto">Publisher programme</p>
            <h2 class="section-heading mt-4">Built for affiliates who run real traffic</h2>
            <p class="section-sub mx-auto">We work with SEO sites, paid media buyers, and email marketers who can prove their sources — and who want a network that pays on time.</p>
        </div>
    </section>

    <section class="py-20 lg:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="section-heading">Publisher benefits</h2>
            <div class="mt-12 grid gap-6 lg:grid-cols-2">
                @foreach ([
                    ['title' => 'Competitive payouts', 'desc' => 'Top-tier rates in finance, iGaming, health, and SaaS with weekly rate reviews for proven partners.'],
                    ['title' => 'Net-30 payouts', 'desc' => 'GBP, EUR, USD with transparent FX. Finance team publishes payout calendar monthly.'],
                    ['title' => 'Deep link & sub-ID tracking', 'desc' => 'Partner reporting with granular breakdowns by sub-ID, device, and geo.'],
                    ['title' => 'Exclusive offers', 'desc' => 'Private caps unlock after 30 days of clean delivery.'],
                    ['title' => 'Creative support', 'desc' => 'Compliant banners and pre-landers approved by our team before go-live.'],
                    ['title' => 'No shaving policy', 'desc' => 'Postback logs available. Discrepancy SLA: 5 business days.'],
                ] as $f)
                    <article class="flex gap-4 rounded-2xl border border-subtle bg-elevated p-6">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-500/15 text-brand-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        </span>
                        <div>
                            <h3 class="font-display font-semibold text-heading">{{ $f['title'] }}</h3>
                            <p class="mt-1 text-sm text-muted">{{ $f['desc'] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <x-faq :items="[
        ['q' => 'What is the payment threshold?', 'a' => '£100 / $100 equivalent minimum. Payments processed net-30 on the 15th for the prior period.'],
        ['q' => 'How are payouts made?', 'a' => 'Bank transfer to your nominated business account in GBP, EUR, or USD — details confirmed at onboarding.'],
        ['q' => 'Do you allow brand bidding?', 'a' => 'Offer-specific. Prohibited unless explicitly allowed in the IO.'],
    ]" />

    <x-cta-banner primaryLabel="Start earning" />
</x-layouts.app>
