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
                Browse live programmes and apply for tracking links after approval.
            </x-slot:subtitle>
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
                        The full catalogue is visible once your partner application is approved. Every programme is configured from a signed IO, not a public self-serve list.
                    </p>
                    <div class="mt-8 flex justify-center">
                        <a href="{{ route('apply') }}" class="btn-primary">Join Network</a>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section class="py-6 sm:py-8 lg:py-12" x-data="offersFilter(@js($offers))">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-4 rounded-xl border border-subtle bg-elevated p-3 shadow-sm">
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-[1fr_repeat(4,minmax(0,8rem))_auto] lg:items-end lg:gap-2">
                        <div class="sm:col-span-2 lg:col-span-1">
                            <label for="offer-search" class="mb-1 block text-[11px] font-semibold uppercase tracking-wider text-muted">Search</label>
                            <input id="offer-search" type="search" x-model="search" placeholder="Offer or ID…" class="form-input w-full py-2 text-sm">
                        </div>
                        <div>
                            <label for="offer-vertical" class="mb-1 block text-[11px] font-semibold uppercase tracking-wider text-muted">Vertical</label>
                            <select id="offer-vertical" x-model="vertical" class="form-input w-full py-2 text-sm">
                                <option value="all">All</option>
                                @foreach ($filters['verticals'] as $v)
                                    <option value="{{ $v['slug'] }}">{{ $v['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="offer-model" class="mb-1 block text-[11px] font-semibold uppercase tracking-wider text-muted">Model</label>
                            <select id="offer-model" x-model="model" class="form-input w-full py-2 text-sm">
                                <option value="all">All</option>
                                @foreach ($filters['models'] as $m)
                                    <option value="{{ $m }}">{{ $m }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="offer-geo" class="mb-1 block text-[11px] font-semibold uppercase tracking-wider text-muted">Geo</label>
                            <select id="offer-geo" x-model="geo" class="form-input w-full py-2 text-sm">
                                <option value="all">All</option>
                                @foreach ($filters['geos'] as $g)
                                    <option value="{{ $g }}">{{ $geoLabels[$g] ?? $g }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="offer-status" class="mb-1 block text-[11px] font-semibold uppercase tracking-wider text-muted">Status</label>
                            <select id="offer-status" x-model="status" class="form-input w-full py-2 text-sm">
                                <option value="all">All</option>
                                <option value="live">Live</option>
                                <option value="limited">Limited</option>
                            </select>
                        </div>
                        <div class="sm:col-span-2 lg:col-span-1 lg:flex lg:justify-end">
                            <button type="button" @click="resetFilters()" class="w-full rounded-lg px-2.5 py-2 text-sm font-medium text-brand-600 hover:bg-brand-500/10 dark:text-brand-400 lg:w-auto lg:py-1.5 lg:text-xs">Clear</button>
                        </div>
                    </div>
                </div>

                <div class="mb-3 flex justify-end" x-show="totalPages > 1">
                    <div class="flex items-center gap-1 text-xs">
                        <button type="button" @click="goToPage(page - 1)" :disabled="page === 1" class="rounded-md border border-subtle px-3 py-1.5 disabled:opacity-40">Prev</button>
                        <span class="px-2 text-muted" x-text="`Page ${page} of ${totalPages}`"></span>
                        <button type="button" @click="goToPage(page + 1)" :disabled="page === totalPages" class="rounded-md border border-subtle px-3 py-1.5 disabled:opacity-40">Next</button>
                    </div>
                </div>

                {{-- Mobile: card list --}}
                <div class="space-y-3 md:hidden" x-show="filtered.length > 0">
                    @foreach ($offers as $index => $offer)
                        @php
                            $statusClass = match ($offer['status']) {
                                'live' => 'bg-emerald-500/15 text-emerald-700 dark:text-emerald-400',
                                'limited' => 'bg-amber-500/15 text-amber-800 dark:text-amber-300',
                                default => 'bg-slate-100 text-slate-600 dark:bg-white/10',
                            };
                        @endphp
                        <article
                            x-show="rowVisible({{ $index }})"
                            class="rounded-xl border border-subtle bg-elevated p-4 shadow-sm"
                        >
                            <div class="flex gap-3">
                                @if ($offer['logo'] ?? null)
                                    <img src="{{ $offer['logo'] }}" alt="{{ $offer['name'] }}" class="h-14 w-14 shrink-0 rounded-lg border border-subtle object-contain bg-white p-1">
                                @else
                                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-lg border border-subtle bg-slate-100 text-xs font-bold text-muted dark:bg-white/5">
                                        {{ strtoupper(substr($offer['name'], 0, 2)) }}
                                    </div>
                                @endif
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-start justify-between gap-2">
                                        <div class="min-w-0">
                                            <p class="font-display font-semibold text-heading">{{ $offer['name'] }}</p>
                                            <p class="mt-0.5 font-mono text-[11px] text-muted">ID {{ $offer['id'] }}</p>
                                        </div>
                                        <span class="inline-flex shrink-0 rounded px-1.5 py-0.5 text-[10px] font-bold uppercase tracking-wider {{ $statusClass }}">{{ $offer['status'] }}</span>
                                    </div>
                                    <dl class="mt-3 grid grid-cols-2 gap-x-3 gap-y-2 text-xs">
                                        <div>
                                            <dt class="font-semibold uppercase tracking-wider text-muted">Vertical</dt>
                                            <dd class="mt-0.5 text-body">{{ $offer['vertical_name'] }}</dd>
                                        </div>
                                        <div>
                                            <dt class="font-semibold uppercase tracking-wider text-muted">Payout</dt>
                                            <dd class="mt-0.5 font-semibold text-brand-600 dark:text-brand-400">{{ $offer['payout'] }}</dd>
                                        </div>
                                        <div class="col-span-2">
                                            <dt class="font-semibold uppercase tracking-wider text-muted">Geos</dt>
                                            <dd class="mt-1">
                                                <x-geo-flags :geos="$offer['geos']" size="lg" />
                                            </dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                            <a href="{{ route('apply') }}?type=publisher&offer={{ $offer['id'] }}" class="btn-primary mt-4 block w-full text-center text-sm">Apply</a>
                        </article>
                    @endforeach
                </div>

                {{-- Desktop: table --}}
                <div class="hidden overflow-x-auto rounded-xl border border-subtle md:block" x-show="filtered.length > 0">
                    <table class="w-full min-w-[720px] text-left text-sm">
                        <thead class="border-b border-subtle bg-elevated text-muted">
                            <tr>
                                <th class="px-4 py-3 font-semibold">Offer</th>
                                <th class="px-4 py-3 font-semibold">Vertical</th>
                                <th class="px-4 py-3 font-semibold">Payout</th>
                                <th class="px-4 py-3 font-semibold">Geos</th>
                                <th class="px-4 py-3 font-semibold">Status</th>
                                <th class="px-4 py-3 font-semibold"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($offers as $index => $offer)
                                @php
                                    $statusClass = match ($offer['status']) {
                                        'live' => 'bg-emerald-500/15 text-emerald-700 dark:text-emerald-400',
                                        'limited' => 'bg-amber-500/15 text-amber-800 dark:text-amber-300',
                                        default => 'bg-slate-100 text-slate-600 dark:bg-white/10',
                                    };
                                @endphp
                                <tr
                                    x-show="rowVisible({{ $index }})"
                                    class="border-b border-subtle-5 hover:bg-slate-50 dark:hover:bg-white/5"
                                >
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            @if ($offer['logo'] ?? null)
                                                <img src="{{ $offer['logo'] }}" alt="{{ $offer['name'] }}" class="h-12 w-12 shrink-0 rounded-lg border border-subtle object-contain bg-white p-1">
                                            @else
                                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg border border-subtle bg-slate-100 text-xs font-bold text-muted dark:bg-white/5">
                                                    {{ strtoupper(substr($offer['name'], 0, 2)) }}
                                                </div>
                                            @endif
                                            <div class="min-w-0">
                                                <p class="font-medium text-heading">{{ $offer['name'] }}</p>
                                                <p class="text-xs font-mono text-muted">{{ $offer['id'] }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-body">{{ $offer['vertical_name'] }}</td>
                                    <td class="px-4 py-3 font-semibold text-brand-600 dark:text-brand-400">{{ $offer['payout'] }}</td>
                                    <td class="px-4 py-3">
                                        <x-geo-flags :geos="$offer['geos']" />
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex rounded px-1.5 py-0.5 text-[10px] font-bold uppercase tracking-wider {{ $statusClass }}">{{ $offer['status'] }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <a href="{{ route('apply') }}?type=publisher&offer={{ $offer['id'] }}" class="inline-flex rounded-md bg-brand-500 px-3 py-1.5 text-xs font-semibold text-white hover:bg-brand-400 dark:text-surface-950">Apply</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 flex justify-end" x-show="totalPages > 1">
                    <div class="flex items-center gap-1 text-xs">
                        <button type="button" @click="goToPage(page - 1)" :disabled="page === 1" class="rounded-md border border-subtle px-2 py-1 disabled:opacity-40">Prev</button>
                        <span class="px-2 text-muted" x-text="`Page ${page} of ${totalPages}`"></span>
                        <button type="button" @click="goToPage(page + 1)" :disabled="page === totalPages" class="rounded-md border border-subtle px-2 py-1 disabled:opacity-40">Next</button>
                    </div>
                </div>

                <div x-show="filtered.length === 0" x-cloak class="rounded-xl border border-dashed border-subtle px-6 py-12 text-center">
                    <p class="font-display text-base font-semibold text-heading">No offers match</p>
                    <button type="button" @click="resetFilters()" class="btn-secondary mt-4 text-sm">Clear filters</button>
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
            heading="Want tracking links?"
            sub="Apply as a publisher and reference an offer ID in your application."
            primaryLabel="Apply as publisher"
        />
    @endif
</x-layouts.app>
