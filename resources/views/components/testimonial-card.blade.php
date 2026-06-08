@props(['testimonial'])

@php
    $initials = collect(explode(' ', $testimonial['name']))->map(fn ($w) => strtoupper(substr($w, 0, 1)))->take(2)->join('');
@endphp

<blockquote class="flex h-full flex-col rounded-2xl border border-subtle bg-elevated shadow-xl">
    <div class="flex items-center gap-4 border-b border-subtle-5 p-6">
        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 font-display text-sm font-bold text-white">
            {{ $initials }}
        </div>
        <div class="min-w-0">
            <cite class="not-italic">
                <span class="block font-display font-semibold text-heading">{{ $testimonial['name'] }}</span>
                <span class="mt-0.5 block truncate text-sm text-muted">{{ $testimonial['role'] }}, {{ $testimonial['company'] }}</span>
            </cite>
            <p class="mt-1 text-xs font-medium text-brand-600 dark:text-brand-400">{{ $testimonial['since'] }}</p>
        </div>
    </div>
    <div class="flex flex-1 flex-col p-6">
        <p class="flex-1 text-sm leading-relaxed text-body">"{{ $testimonial['quote'] }}"</p>
    </div>
</blockquote>
