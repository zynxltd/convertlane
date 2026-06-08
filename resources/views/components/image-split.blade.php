@props([
    'page',
    'alt',
    'eyebrow' => null,
    'reverse' => false,
    'simple' => false,
])

@php
    $image = $simple ? null : \App\Support\BrandImages::sectionForPage($page);
@endphp

<section class="border-y border-subtle-5 bg-white py-16 lg:py-24 dark:bg-surface-900/50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div @class([
            'grid items-center gap-10',
            'lg:grid-cols-2 lg:gap-16' => $image,
        ])>
            @if ($image)
                <div class="photo-frame-lg aspect-[4/3] overflow-hidden rounded-2xl border border-subtle shadow-lg lg:aspect-auto lg:min-h-[420px] {{ $reverse ? 'lg:order-2' : '' }}">
                    <img
                        src="{{ asset($image) }}"
                        alt="{{ $alt }}"
                        class="img-cover min-h-[280px] lg:min-h-[420px]"
                        loading="lazy"
                        decoding="async"
                        width="1400"
                        height="1050"
                    >
                </div>
            @endif
            <div @class([
                'max-w-3xl',
                'mx-auto text-center' => ! $image,
                $reverse && $image ? 'lg:order-1' : '',
            ])>
                @if ($eyebrow)
                    <p class="eyebrow {{ $image ? '' : 'mx-auto' }}">{{ $eyebrow }}</p>
                @endif
                {{ $slot }}
            </div>
        </div>
    </div>
</section>
