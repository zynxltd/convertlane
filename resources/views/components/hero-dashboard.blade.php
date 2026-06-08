@php
    $dashboard = config('brand.hero_dashboard');
    $stats = $dashboard['stats'] ?? [];
    $bars = $dashboard['bars'] ?? [35, 55, 40, 70, 50, 80, 60, 90, 55, 75, 65, 85];
@endphp

<div class="relative mx-auto w-full max-w-lg lg:max-w-none" aria-hidden="true">
    <div class="absolute -inset-6 rounded-[2rem] bg-gradient-to-br from-brand-400/30 via-cyan-400/20 to-violet-500/25 blur-3xl"></div>

    <div class="hero-dashboard-card relative overflow-hidden rounded-2xl border border-white/60 bg-white/95 shadow-2xl shadow-slate-900/10 ring-1 ring-slate-900/5 backdrop-blur-md dark:border-white/15 dark:bg-slate-900/92 dark:shadow-black/40 dark:ring-white/10">
        <div class="flex items-center gap-2 border-b border-slate-200/80 bg-slate-50/90 px-4 py-3 dark:border-white/10 dark:bg-slate-800/80">
            <span class="h-2.5 w-2.5 rounded-full bg-[#ff5f57] shadow-sm"></span>
            <span class="h-2.5 w-2.5 rounded-full bg-[#febc2e] shadow-sm"></span>
            <span class="h-2.5 w-2.5 rounded-full bg-[#28c840] shadow-sm"></span>
            <span class="ml-2 font-mono text-xs font-medium text-slate-600 dark:text-slate-300">Performance dashboard</span>
            <span class="ml-auto rounded-md bg-slate-200/80 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wider text-slate-500 dark:bg-white/10 dark:text-slate-400">Sample</span>
        </div>

        <div class="grid grid-cols-3 divide-x divide-slate-200/80 dark:divide-white/10">
            @foreach ($stats as $stat)
                <div class="px-4 py-4 sm:py-5">
                    <p class="text-[10px] font-semibold uppercase tracking-wider text-slate-500">{{ $stat['label'] }}</p>
                    <p class="mt-1.5 font-display text-2xl font-bold tabular-nums tracking-tight text-slate-900 dark:text-white sm:text-[1.65rem]">{{ $stat['value'] }}</p>
                    @if (! empty($stat['delta']))
                        <p class="mt-1 inline-flex items-center rounded-full bg-emerald-500/10 px-2 py-0.5 text-xs font-semibold text-emerald-700 dark:text-emerald-400">{{ $stat['delta'] }}</p>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="border-t border-slate-200/80 px-4 py-4 dark:border-white/10">
            <p class="text-[10px] font-semibold uppercase tracking-wider text-slate-500">Performance — last 12 periods</p>
            <div class="mt-4 flex h-32 items-end justify-between gap-1 sm:h-36 sm:gap-1.5">
                @foreach ($bars as $i => $h)
                    <div
                        class="hero-dashboard-bar flex-1 rounded-t-md bg-gradient-to-t from-brand-700 to-brand-400 dark:from-brand-600 dark:to-cyan-400"
                        style="height: {{ $h }}%; animation-delay: {{ $i * 40 }}ms"
                    ></div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="absolute -bottom-5 -left-2 z-10 hidden max-w-[11rem] rounded-xl border border-white/70 bg-white/95 px-4 py-3 shadow-xl shadow-slate-900/15 backdrop-blur-md dark:border-brand-500/30 dark:bg-slate-900/95 sm:block">
        <p class="text-xs font-semibold text-brand-700 dark:text-brand-300">Live performance stats</p>
        <p class="mt-0.5 text-[10px] leading-snug text-slate-500">Clicks, conversions & EPC</p>
    </div>
</div>
