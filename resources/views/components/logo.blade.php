@props([
    'variant' => 'full', // full | mark | wordmark | stacked
    'size' => 'md', // sm | md | lg
    'tagline' => false,
])

@php
    $logoSrc = config('brand.logo', '/images/convertlane-logo.png');
    $logoAlt = config('brand.name');

    $heights = [
        'sm' => 'h-7',
        'md' => 'h-9 sm:h-10',
        'lg' => 'h-11 sm:h-12',
    ];
    $height = $heights[$size] ?? $heights['md'];

    $tagSizes = [
        'sm' => 'text-[9px]',
        'md' => 'text-[10px]',
        'lg' => 'text-[11px]',
    ];
    $tagSize = $tagSizes[$size] ?? $tagSizes['md'];

    $stacked = $variant === 'stacked';
    $showTagline = $tagline && $variant !== 'mark';
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex ' . ($stacked ? 'flex-col items-start gap-2' : 'items-center')]) }}>
    <span class="flex min-w-0 flex-col justify-center">
        <img
            src="{{ asset($logoSrc) }}"
            alt="{{ $logoAlt }}"
            class="w-auto shrink-0 object-contain object-left {{ $height }}"
            width="686"
            height="150"
            decoding="async"
        />

        @if ($showTagline)
            <span @class([
                'mt-1 font-medium uppercase tracking-[0.18em] text-brand-700/90 dark:text-brand-300/90',
                $tagSize,
                'hidden lg:block' => $tagline && ! $stacked,
            ])>
                {{ config('brand.tagline') }}
            </span>
        @endif
    </span>

    @if ($stacked)
        <span class="max-w-[14rem] text-xs leading-snug text-muted">
            {{ config('brand.descriptor') }}
        </span>
    @endif
</span>
