@props([
    'videos' => null,
    'rotate' => true,
    'rotateInterval' => null,
])

@php
    $sources = $videos ?? config('brand.hero_videos', []);
    $interval = $rotateInterval ?? config('brand.hero_rotate_interval', 5000);
    $shouldRotate = $rotate && count($sources) > 1;
@endphp

<div
    class="hero-media{{ $shouldRotate ? ' hero-media--rotate' : '' }}"
    aria-hidden="true"
    @if ($shouldRotate)
        data-hero-rotate="{{ $interval }}"
        data-hero-videos='@json(collect($sources)->map(fn ($v) => asset($v))->values())'
        data-hero-tone="0"
    @endif
>
    @if ($shouldRotate)
        <div class="hero-video-stack">
            <div class="hero-video-layer" data-layer="a">
                <video class="hero-video" muted playsinline preload="auto"></video>
            </div>
            <div class="hero-video-layer" data-layer="b">
                <video class="hero-video" muted playsinline preload="auto"></video>
            </div>
        </div>
        <div class="hero-media-vignette"></div>
        <div class="hero-media-grain"></div>
        <div class="hero-media-progress" aria-hidden="true">
            @foreach ($sources as $i => $video)
                <span class="hero-media-progress-dot{{ $i === 0 ? ' is-active' : '' }}" data-index="{{ $i }}">
                    <span class="hero-media-progress-fill"></span>
                </span>
            @endforeach
        </div>
    @else
        <video class="hero-video" autoplay muted loop playsinline preload="auto">
            <source src="{{ asset($sources[0] ?? config('brand.hero_video', '/videos/hero-bg-1.mp4')) }}" type="video/mp4">
        </video>
    @endif
    <canvas class="hero-video-canvas" id="hero-video-canvas"></canvas>
    <div class="hero-media-overlay"></div>
</div>
