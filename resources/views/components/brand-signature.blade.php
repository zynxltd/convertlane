@props(['align' => 'left'])

<div {{ $attributes->merge(['class' => 'flex flex-col gap-3 ' . ($align === 'center' ? 'items-center text-center' : '')]) }}>
    <div class="inline-flex items-center gap-2 rounded-full border border-brand-500/25 bg-brand-500/10 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-brand-700 dark:text-brand-300">
        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
        </svg>
        UK-registered · {{ config('brand.registered') }}
    </div>
    <p class="max-w-md font-display text-lg font-semibold leading-snug text-heading sm:text-xl">
        {{ config('brand.signature') }}
    </p>
</div>
