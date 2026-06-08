@props([
    'variant' => 'centered',
    'priority' => false,
    'image' => null,
])

@php
    $backgroundImage = $image ?? config('brand.hero_background');
    $useVideo = config('brand.hero_use_video', true) && config('brand.hero_video') && ! $image;
@endphp

<div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
    @if ($useVideo)
        <video
            class="hero-video-media absolute inset-0 h-full w-full object-cover"
            @class([
                'hero-video-media--cinematic' => $variant === 'cinematic',
            ])
            autoplay
            muted
            loop
            playsinline
            preload="{{ $priority ? 'auto' : 'metadata' }}"
            @if ($priority) fetchpriority="high" @endif
            poster="{{ asset(config('brand.hero_video_poster', $backgroundImage)) }}"
        >
            <source src="{{ asset(config('brand.hero_video')) }}" type="video/mp4">
        </video>
    @else
        <div
            class="hero-image-media absolute inset-0 bg-cover bg-center"
            @class([
                'hero-image-media--cinematic' => $variant === 'cinematic',
            ])
            style="background-image: url('{{ asset($backgroundImage) }}')"
        ></div>
    @endif
    <div @class([
        'hero-video-overlay absolute inset-0',
        'hero-video-overlay--split' => $variant === 'split',
        'hero-video-overlay--centered' => $variant === 'centered',
        'hero-video-overlay--cinematic' => $variant === 'cinematic',
    ])></div>
    <div class="hero-video-vignette absolute inset-0" @class([
        'hero-video-vignette--cinematic' => $variant === 'cinematic',
    ]) aria-hidden="true"></div>
    @if ($variant === 'cinematic')
        <div class="hero-video-grain absolute inset-0" aria-hidden="true"></div>
    @endif
    <div class="hero-video-fallback absolute inset-0 bg-gradient-to-br from-slate-100 via-brand-50 to-cyan-50 dark:from-surface-950 dark:via-brand-950/50 dark:to-surface-900"></div>
</div>
