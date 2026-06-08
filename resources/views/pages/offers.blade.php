@php
    $geoLabels = [
        'GB' => 'United Kingdom',
        'IE' => 'Ireland',
        'US' => 'United States',
        'CA' => 'Canada',
        'DE' => 'Germany',
        'AT' => 'Austria',
        'BR' => 'Brazil',
        'AU' => 'Australia',
        'MX' => 'Mexico',
    ];
    $hasOffers = $counts['total'] > 0;
@endphp

<x-layouts.app
    title="Live Offers"
    description="Browse ConvertLane CPA, CPL, and CPS offers by vertical. Apply for tracking links after partner approval."
>
    <x-page-hero eyebrow="Publisher catalogue">
        <x-slot:title>Live <span class="text-gradient-hero">offers</span></x-slot:title>
        @if ($hasOffers)
            <x-slot:subtitle>
                {{ $counts['total'] }} {{ $counts['total'] === 1 ? 'programme' : 'programmes' }} across {{ count($filters['verticals']) }} verticals.
                Tracking links are issued after partner approval.
            </x-slot:subtitle>
            <x-slot:meta>
                <div class="flex flex-wrap gap-2 text-sm">
                    <span class="rounded-full border border-subtle bg-white/80 px-3 py-1 text-muted backdrop-blur-sm dark:bg-white/10">{{ $counts['live'] }} live</span>
                    @if ($counts['in_house'] > 0)
                        <span class="rounded-full border border-brand-500/30 bg-brand-500/10 px-3 py-1 font-medium text-brand-700 dark:text-brand-300">{{ $counts['in_house'] }} in-house</span>
                    @endif
                    @if ($counts['partner'] > 0)
                        <span class="rounded-full border border-subtle bg-white/80 px-3 py-1 text-muted backdrop-blur-sm dark:bg-white/10">{{ $counts['partner'] }} partner</span>
                    @endif
                </div>
            </x-slot:meta>
        @else
            <x-slot:subtitle>
                Live programmes are available to approved network partners. Join ConvertLane to browse offers and request tracking links.
            </x-slot:subtitle>
        @endif
    </x-page-hero>

    @if (! $hasOffers)
        <section class="py-16 lg:py-24">
            <div class="mx-auto max-w-xl px-4 text-center sm:px-6">
                <div class="rounded-2xl border border-subtle bg-elevated p-10 shadow-lg">
                    <p class="eyebrow mx-auto">Members only</p>
                    <p class="mt-4 font-display text-2xl font-semibold text-heading">Join the network to see live offers</p>
                    <p class="mt-3 text-sm text-muted leading-relaxed">
                        The full catalogue is visible once your partner application is approved. Every programme is configured from a signed IO — not a public self-serve list.
                    </p>
                    <div class="mt-8 flex justify-center">
                        <a href="{{ route('apply') }}" class="btn-primary">Join Network</a>
                    </div>
                </div>
            </div>
        </section>
    @else
        @if (count($inHouseBrands) > 0)
            <section class="border-b border-subtle-5 bg-slate-50/80 py-10 dark:bg-surface-950">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <h2 class="font-display text-sm font-bold uppercase tracking-wider text-slate-500">In-house brands</h2>
                    <p class="mt-1 max-w-2xl text-sm text-muted">Programmes operated directly on ConvertLane.</p>
                    <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach ($inHouseBrands as $brand)
                            <div class="rounded-xl border border-brand-500/25 bg-elevated p-4">
                                <div class="flex items-center gap-2">
                                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-brand-500/15 text-xs font-bold text-brand-600 dark:text-brand-300">
                                        {{ strtoupper(substr($brand['name'], 0, 2)) }}
                                    </span>
                                    <span class="font-display font-semibold text-heading">{{ $brand['name'] }}</span>
                                </div>
                                <p class="mt-2 text-xs leading-relaxed text-muted">{{ $brand['tagline'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <section class="py-12 lg:py-16" x-data="offersFilter(@js($offers))">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="lg:grid lg:grid-cols-[240px_1fr] lg:gap-10">
                    <aside class="mb-8 lg:mb-0">
                        <div class="sticky top-24 space-y-6 rounded-2xl border border-subtle bg-elevated p-5 shadow-lg">
                            <div>
                                <label for="offer-search" class="form-label">Search</label>
                                <input id="offer-search" type="search" x-model="search" placeholder="Offer or brand…" class="form-input mt-0">
                            </div>
                            <div>
                                <span class="form-label">Vertical</span>
                                <div class="mt-2 flex flex-wrap gap-1.5">
                                    <button type="button" @click="vertical = 'all'" class="rounded-lg px-2.5 py-1.5 text-xs font-medium transition" :class="vertical === 'all' ? 'bg-brand-500 text-white dark:text-surface-950' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-white/5 dark:text-slate-300'">All</button>
                                    @foreach ($filters['verticals'] as $v)
                                        <button type="button" @click="vertical = '{{ $v['slug'] }}'" class="rounded-lg px-2.5 py-1.5 text-xs font-medium transition" :class="vertical === '{{ $v['slug'] }}' ? 'bg-brand-500 text-white dark:text-surface-950' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-white/5 dark:text-slate-300'">{{ explode(' ', $v['name'])[0] }}</button>
                                    @endforeach
                                </div>
                            </div>
                            <div>
                                <label for="offer-model" class="form-label">Payout model</label>
                                <select id="offer-model" x-model="model" class="form-input mt-0">
                                    <option value="all">All models</option>
                                    @foreach ($filters['models'] as $m)
                                        <option value="{{ $m }}">{{ $m }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="offer-geo" class="form-label">Geo</label>
                                <select id="offer-geo" x-model="geo" class="form-input mt-0">
                                    <option value="all">All geos</option>
                                    @foreach ($filters['geos'] as $g)
                                        <option value="{{ $g }}">{{ $geoLabels[$g] ?? $g }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="offer-status" class="form-label">Status</label>
                                <select id="offer-status" x-model="status" class="form-input mt-0">
                                    <option value="all">All statuses</option>
                                    <option value="live">Live</option>
                                    <option value="limited">Limited cap</option>
                                    <option value="private">Private</option>
                                </select>
                            </div>
                            <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-subtle px-3 py-2.5">
                                <input type="checkbox" x-model="inHouseOnly" class="rounded border-slate-300 text-brand-500 focus:ring-brand-500 dark:border-white/20">
                                <span class="text-sm font-medium text-body">In-house brands only</span>
                            </label>
                            <button type="button" @click="resetFilters()" class="w-full text-center text-sm font-medium text-brand-600 hover:text-brand-500 dark:text-brand-400">Clear filters</button>
                        </div>
                    </aside>

                    <div>
                        <p class="mb-6 text-sm text-muted" x-text="resultLabel"></p>
                        <div class="grid gap-4 sm:grid-cols-2" x-show="filtered.length > 0">
                            <template x-for="offer in filtered" :key="offer.id">
                                <article class="flex flex-col rounded-2xl border border-subtle bg-elevated shadow-lg">
                                    <div class="flex flex-wrap items-start justify-between gap-2 border-b border-subtle-5 p-5">
                                        <div class="min-w-0">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <span class="inline-flex rounded-md px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider" :class="offer.in_house ? 'bg-brand-500/15 text-brand-700 dark:text-brand-300' : 'bg-slate-100 text-slate-600 dark:bg-white/10'" x-text="offer.in_house ? 'In-house' : 'Partner'"></span>
                                                <span class="inline-flex rounded-md px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider" :class="{'bg-emerald-500/15 text-emerald-700 dark:text-emerald-400': offer.status === 'live', 'bg-amber-500/15 text-amber-800 dark:text-amber-300': offer.status === 'limited', 'bg-violet-500/15 text-violet-700 dark:text-violet-300': offer.status === 'private'}" x-text="offer.status"></span>
                                            </div>
                                            <h2 class="mt-2 font-display text-lg font-semibold text-heading" x-text="offer.name"></h2>
                                            <p class="mt-0.5 text-sm text-muted"><span x-text="offer.brand"></span> · <span x-text="offer.vertical_name"></span></p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-display text-2xl font-bold text-brand-600 dark:text-brand-400" x-text="offer.payout"></p>
                                            <p class="text-xs text-muted" x-text="offer.model + ' · ' + offer.event"></p>
                                        </div>
                                    </div>
                                    <div class="flex flex-1 flex-col p-5">
                                        <p class="text-sm leading-relaxed text-body" x-text="offer.description"></p>
                                        <dl class="mt-4 grid grid-cols-2 gap-3 text-xs">
                                            <div><dt class="font-semibold uppercase tracking-wider text-slate-500">Geos</dt><dd class="mt-0.5 text-body" x-text="offer.geos.join(', ')"></dd></div>
                                            <div><dt class="font-semibold uppercase tracking-wider text-slate-500">Cap</dt><dd class="mt-0.5 text-body" x-text="offer.cap"></dd></div>
                                        </dl>
                                        <a :href="'{{ route('apply') }}?type=publisher&offer=' + offer.id" class="btn-primary mt-5 w-full text-center text-sm">Apply for access</a>
                                    </div>
                                </article>
                            </template>
                        </div>
                        <div x-show="filtered.length === 0" x-cloak class="rounded-2xl border border-dashed border-subtle px-6 py-16 text-center">
                            <p class="font-display text-lg font-semibold text-heading">No offers match</p>
                            <button type="button" @click="resetFilters()" class="btn-secondary mt-6">Clear filters</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if (! $hasOffers)
        <x-cta-banner
            heading="Ready to browse live programmes?"
            sub="Approved partners get full catalogue access, tracking links, and a named account manager."
            primaryLabel="Join Network"
        />
    @else
        <x-cta-banner
            heading="Want access when offers go live?"
            sub="Approved publishers receive tracking links and a named account manager. Reference an offer ID in your application if you have one."
            primaryLabel="Apply as publisher"
        />
    @endif
</x-layouts.app>
