<x-layouts.app
    title="For Advertisers"
    description="Launch CPA, CPL, and CPS offers on ConvertLane. Vetted publishers, conversion tracking, fraud screening, and dedicated account management."
>
    <x-page-hero eyebrow="For advertisers">
        <x-slot:title>Acquire customers at <span class="text-gradient-hero">predictable CPA</span></x-slot:title>
        <x-slot:subtitle>Performance marketing with publishers who are vetted before they send a single click — with finance-controlled billing and signed IOs on every offer.</x-slot:subtitle>
        <x-slot:actions>
            <a href="{{ route('advertiser.enquiry') }}" class="btn-primary">Launch an offer</a>
            <a href="{{ route('contact') }}" class="btn-secondary">Book a call</a>
        </x-slot:actions>
    </x-page-hero>

    <section class="border-y border-subtle-5 bg-slate-100/60 py-16 dark:bg-elevated-muted/60 lg:py-20">
        <div class="mx-auto max-w-3xl px-4 text-center sm:px-6 lg:px-8">
            <p class="eyebrow mx-auto">Advertiser programme</p>
            <h2 class="section-heading mt-4">Quality over quantity</h2>
            <p class="section-sub mx-auto">We recruit publishers against your vertical and geo — not whoever signs up fastest. New advertisers typically start on prepay until delivery is proven.</p>
        </div>
    </section>

    <section class="py-20 lg:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="section-heading text-center">Why brands choose ConvertLane</h2>
            <div class="mt-14 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ([
                    ['title' => 'Vetted publisher pool', 'desc' => 'Traffic proof, sanctions screening, and probation caps on new partners.'],
                    ['title' => 'Real-time cap management', 'desc' => 'Daily, weekly, and monthly caps with pause rules when limits are reached.'],
                    ['title' => 'Fraud & brand protection', 'desc' => 'IP filtering, duplicate detection, brand bidding enforcement.'],
                    ['title' => 'Dedicated account team', 'desc' => 'Named AM and compliance contact on every account.'],
                    ['title' => 'Flexible payout models', 'desc' => 'CPA, CPL, CPS, tiered and hybrid structures.'],
                    ['title' => 'Geo targeting', 'desc' => 'Caps and creatives scoped to the countries on your IO.'],
                ] as $f)
                    <article class="rounded-2xl border border-subtle bg-elevated p-6 shadow-lg">
                        <h3 class="font-display text-lg font-semibold text-heading">{{ $f['title'] }}</h3>
                        <p class="mt-2 text-sm text-muted">{{ $f['desc'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <x-cta-banner heading="Launch your next offer" primaryLabel="Advertiser enquiry" primaryRoute="advertiser.enquiry" secondaryLabel="Book a discovery call" />
</x-layouts.app>
