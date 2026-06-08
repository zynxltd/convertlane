@php
    $heroItems = config('brand.hero_items');
@endphp

<section class="home-hero is-entered" aria-labelledby="home-hero-heading">
    <x-hero-media />

    <div class="home-hero-spotlight" aria-hidden="true"></div>

    <div class="home-hero-layout relative z-10 mx-auto w-full max-w-3xl px-4 text-center sm:px-6">
        <div class="home-hero-copy">
            <div class="home-hero-intro">
                <p class="home-hero-eyebrow">
                    <span class="home-hero-dot" aria-hidden="true"></span>
                    <span id="hero-eyebrow">{{ $heroItems[0]['eyebrow'] }}</span>
                </p>

                <h1 id="home-hero-heading" class="home-hero-title">
                    <span class="hero-prefix" id="hero-prefix">{{ $heroItems[0]['verb'] }}</span>
                    <span
                        class="hero-scroll"
                        id="hero-scroll"
                        aria-hidden="true"
                        data-slides='@json($heroItems)'
                    >
                        <span class="hero-scroll-viewport">
                            <span class="hero-scroll-inner" id="hero-scroll-inner">
                                @foreach ($heroItems as $item)
                                    <span class="hero-scroll-word">{{ $item['word'] }}</span>
                                @endforeach
                            </span>
                        </span>
                    </span>
                    <span class="sr-only" aria-live="polite" id="hero-scroll-live">{{ $heroItems[0]['verb'] }} {{ $heroItems[0]['word'] }}</span>
                    <span class="home-hero-tagline" id="hero-tagline">{{ $heroItems[0]['tagline'] }}</span>
                </h1>
            </div>

            <div class="home-hero-cta">
                <div class="home-hero-actions">
                    <a href="{{ route('apply') }}?type=publisher" class="btn-hero btn-hero-primary">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        Join as Publisher
                    </a>
                    <a href="{{ route('advertiser.enquiry') }}" class="btn-hero btn-hero-ghost">Launch an Offer</a>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
    @vite(['resources/js/hero-video.js', 'resources/js/hero-scroll.js'])
@endpush
