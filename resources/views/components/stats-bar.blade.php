@php
    $statIcons = [
        'Core verticals' => 'grid',
        'Offers' => 'offers',
        'Payouts' => 'payouts',
    ];
@endphp

<section class="stats-bar relative z-20 -mt-10 pb-2 sm:-mt-12" aria-label="Network statistics">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <div class="stats-bar-panel overflow-hidden rounded-2xl border border-white/60 bg-white/80 shadow-2xl shadow-slate-900/10 ring-1 ring-slate-900/5 backdrop-blur-xl dark:border-white/10 dark:bg-slate-900/90 dark:shadow-black/40 dark:ring-white/10">
            <div class="pointer-events-none absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-brand-400/70 to-transparent" aria-hidden="true"></div>

            <div class="grid divide-y divide-slate-200/80 sm:grid-cols-3 sm:divide-x sm:divide-y-0 dark:divide-white/10">
                @foreach (config('brand.stats') as $stat)
                    @php
                        $icon = $statIcons[$stat['label']] ?? 'grid';
                    @endphp
                    <article class="group relative flex flex-col items-center px-6 py-8 text-center sm:px-8 sm:py-9">
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-500/15 via-cyan-500/10 to-violet-500/10 text-brand-600 ring-1 ring-brand-500/20 transition duration-300 group-hover:scale-105 group-hover:ring-brand-400/40 dark:text-brand-300">
                            @if ($icon === 'grid')
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
                            @elseif ($icon === 'offers')
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/></svg>
                            @else
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                            @endif
                        </div>

                        <p class="font-display text-4xl font-bold tracking-tight sm:text-[2.75rem]">
                            <span class="bg-gradient-to-br from-slate-900 via-brand-600 to-cyan-500 bg-clip-text text-transparent dark:from-white dark:via-brand-300 dark:to-cyan-300">{{ $stat['value'] }}</span>
                        </p>
                        <p class="mt-2 text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400">{{ $stat['label'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>
