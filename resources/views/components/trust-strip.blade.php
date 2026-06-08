@props(['showBrands' => false])

@php
    $highlights = collect(config('brand.trust_highlights'))->map(function ($item) {
        if (($item['icon'] ?? '') === 'building') {
            $item['detail'] = config('brand.registered');
        }

        return $item;
    });
    $badges = config('brand.trust_badges');
    $brandLoop = [];
    if ($showBrands) {
        $brands = app(\App\Services\OfferCatalog::class)->partnerBrands();
        $brandLoop = count($brands) > 0 ? array_merge($brands, $brands) : [];
    }
@endphp

<section class="trust-band relative z-30" aria-labelledby="trust-section-heading">
    <div class="trust-band__inner relative mx-auto max-w-7xl px-4 pb-14 sm:px-6 lg:px-8 lg:pb-16">
        <p id="trust-section-heading" class="sr-only">Trust and credentials</p>

        <div class="trust-band-panel overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-2xl shadow-slate-900/15 ring-1 ring-slate-900/5 dark:border-white/10 dark:bg-slate-900/95 dark:shadow-black/50 dark:ring-white/10">
            {{-- Primary credentials --}}
            <div class="trust-highlights-row flex divide-x divide-slate-200/80 overflow-x-auto dark:divide-white/10 sm:grid sm:grid-cols-3 sm:overflow-visible">
                @foreach ($highlights as $item)
                    <div class="trust-highlight flex min-w-[min(100%,17rem)] flex-1 items-center gap-4 px-5 py-5 snap-start sm:min-w-0 sm:flex-col sm:items-start sm:px-6 sm:py-6 lg:px-8 lg:py-7">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-brand-500/15 to-cyan-500/10 text-brand-600 ring-1 ring-brand-500/20 dark:text-brand-400">
                            @if ($item['icon'] === 'building')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008H17.25v-.008zm0 3h.008v.008H17.25v-.008zm0 3h.008v.008H17.25v-.008z"/></svg>
                            @elseif ($item['icon'] === 'document')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                            @elseif ($item['icon'] === 'chart')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 18h16M7 16l3-6 4 3 5-9"/></svg>
                            @else
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                            @endif
                        </div>
                        <div class="min-w-0">
                            <p class="text-[11px] font-semibold uppercase tracking-[0.14em] text-slate-500">{{ $item['label'] }}</p>
                            <p class="mt-1 font-display text-base font-semibold tracking-tight text-slate-900 dark:text-white sm:text-lg">{{ $item['detail'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Capabilities — single integrated row --}}
            <div class="trust-capabilities border-t border-slate-200/80 bg-slate-50/90 px-4 py-4 dark:border-white/10 dark:bg-slate-800/50 sm:px-6">
                <ul class="trust-capabilities-list flex items-center justify-start gap-2 sm:justify-center sm:gap-0">
                    @foreach ($badges as $badge)
                        <li class="trust-capability flex shrink-0 items-center gap-2 text-sm font-medium text-slate-700 dark:text-slate-300">
                            <svg class="h-4 w-4 shrink-0 text-brand-600 dark:text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                            </svg>
                            <span>{{ $badge['name'] }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        @if ($showBrands && count($brandLoop) > 0)
            <div class="mt-12">
                <div class="mb-5 flex items-end justify-between gap-4">
                    <div>
                        <p class="eyebrow">Advertisers on the network</p>
                        <h2 class="mt-2 font-display text-lg font-semibold text-heading">Brands we work with</h2>
                    </div>
                    <a href="{{ route('offers') }}" class="shrink-0 text-sm font-semibold text-brand-600 hover:text-brand-500 dark:text-brand-400">
                        View offers →
                    </a>
                </div>

                <div class="brand-marquee" role="region" aria-label="Partner brands">
                    <div class="brand-marquee-fade brand-marquee-fade--left" aria-hidden="true"></div>
                    <div class="brand-marquee-fade brand-marquee-fade--right" aria-hidden="true"></div>
                    <div class="brand-marquee-viewport">
                        <div class="brand-marquee-track">
                            @foreach ($brandLoop as $brand)
                                @php
                                    $logoPath = $brand['logo'] ?? null;
                                    $hasLogo = $logoPath && file_exists(public_path(ltrim($logoPath, '/')));
                                @endphp
                                <div class="brand-marquee-item">
                                    @if ($hasLogo)
                                        <img src="{{ asset($logoPath) }}" alt="{{ $brand['name'] }}" class="max-h-7 max-w-[6.5rem] object-contain" loading="lazy">
                                    @else
                                        <span class="font-display text-sm font-semibold text-slate-600 dark:text-slate-300">{{ $brand['name'] }}</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
