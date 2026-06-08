@props(['compact' => false])

<section {{ $attributes->merge(['class' => 'border-y border-subtle-5 bg-slate-50 py-16 lg:py-20 dark:bg-surface-950']) }}>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        @unless ($compact)
            <div class="mx-auto max-w-2xl text-center">
                <p class="eyebrow mx-auto">How we work</p>
                <h2 class="section-heading mt-4">What you actually get</h2>
                <p class="section-sub mx-auto">{{ config('brand.origin') }}</p>
            </div>
        @endunless

        <div class="mt-12 grid gap-6 {{ $compact ? 'md:grid-cols-3' : 'md:grid-cols-3 lg:gap-8' }}">
            @foreach (config('brand.identity.pillars') as $pillar)
                <article class="brand-pillar-card group relative overflow-hidden rounded-2xl border border-subtle bg-elevated p-6 shadow-lg lg:p-8">
                    <div class="brand-pillar-glow pointer-events-none absolute -right-8 -top-8 h-32 w-32 rounded-full opacity-60" aria-hidden="true"></div>
                    <div class="relative">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl border border-brand-500/25 bg-brand-500/10 text-brand-600 dark:text-brand-300">
                            @if ($pillar['icon'] === 'lane')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" d="M7 20V8M12 20V4M17 20V12"/>
                                </svg>
                            @elseif ($pillar['icon'] === 'chart')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 18h16M7 16l3-6 4 3 5-9"/>
                                </svg>
                            @else
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                                </svg>
                            @endif
                        </div>
                        <h3 class="mt-5 font-display text-lg font-semibold text-heading">{{ $pillar['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-muted">{{ $pillar['description'] }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
