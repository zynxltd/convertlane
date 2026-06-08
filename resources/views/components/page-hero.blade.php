@props([
    'eyebrow' => null,
    'showDashboard' => false,
    'showLogo' => false,
    'heroImage' => null,
])

<section class="page-hero relative z-0 min-h-[22rem] overflow-hidden border-b-0 pb-14 pt-24 sm:min-h-[26rem] sm:pb-16 sm:pt-28 lg:min-h-[28rem] lg:pb-20 lg:pt-32">
    <x-hero-video variant="cinematic" :priority="request()->routeIs('home')" :image="$heroImage" />

    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="hero-content-readable mx-auto grid max-w-3xl items-center gap-8 text-center lg:max-w-4xl">
            <div class="hero-copy-panel mx-auto w-full max-w-2xl">
                @if ($showLogo)
                    <x-logo variant="mark" size="lg" class="mb-6" />
                @endif
                @if (isset($prepend))
                    <div class="mb-4">
                        {{ $prepend }}
                    </div>
                @endif
                @if ($eyebrow)
                    <p class="eyebrow">
                        <span class="h-1.5 w-1.5 rounded-full bg-brand-500 animate-pulse dark:bg-brand-400"></span>
                        {{ $eyebrow }}
                    </p>
                @endif
                <h1 class="mt-6 font-display text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl lg:text-[3.25rem] lg:leading-[1.1] dark:text-white">
                    {!! $title !!}
                </h1>
                @if (isset($subtitle))
                    <p class="mt-6 text-lg leading-relaxed text-slate-700 sm:text-xl dark:text-slate-300">
                        {!! $subtitle !!}
                    </p>
                @endif
                @if (isset($meta))
                    <div class="mt-6">
                        {{ $meta }}
                    </div>
                @endif
                @if (isset($actions))
                    <div class="mt-10 flex flex-col gap-4 sm:flex-row">
                        {{ $actions }}
                    </div>
                @endif
            </div>

            @if ($showDashboard)
                <div class="relative mx-auto w-full max-w-lg">
                    <x-hero-dashboard />
                </div>
            @endif
        </div>
    </div>
</section>
