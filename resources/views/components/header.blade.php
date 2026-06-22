@php
    $route = request()->route()?->getName();
    $partnerLoginUrl = route('partner.login');
    $advertiserLoginUrl = route('advertiser.login');
    $overlay = request()->routeIs('home');
@endphp

<header @class([
    'z-40',
    'site-header-overlay' => $overlay,
    'sticky top-0 border-b border-subtle-5 bg-white/70 backdrop-blur-2xl dark:bg-surface-950/70' => ! $overlay,
])>
    <div @class([
        'mx-auto flex items-center justify-between gap-4',
        'site-header-bar max-w-7xl px-4 py-2.5 sm:px-5 lg:px-6' => $overlay,
        'max-w-7xl px-4 py-3 sm:px-6 lg:px-8' => ! $overlay,
    ])>
        <a href="{{ route('home') }}" class="group min-w-0" aria-label="{{ config('brand.name') }}">
            <x-logo size="md" class="transition group-hover:opacity-90" />
        </a>

        <nav @class([
            'hidden items-center lg:flex',
            'nav-pills gap-0.5' => $overlay,
            'gap-0.5' => ! $overlay,
        ]) aria-label="Main">
            <a href="{{ route('advertisers') }}" @class(['nav-link', 'nav-link-active' => $route === 'advertisers', 'nav-pill' => $overlay, 'nav-pill-active' => $overlay && $route === 'advertisers'])>Advertisers</a>
            <a href="{{ route('publishers') }}" @class(['nav-link', 'nav-link-active' => $route === 'publishers', 'nav-pill' => $overlay, 'nav-pill-active' => $overlay && $route === 'publishers'])>Publishers</a>
            <a href="{{ route('offers') }}" @class(['nav-link', 'nav-link-active' => $route === 'offers', 'nav-pill' => $overlay, 'nav-pill-active' => $overlay && $route === 'offers'])>Live offers</a>
            <a href="{{ route('verticals') }}" @class(['nav-link', 'nav-link-active' => $route === 'verticals', 'nav-pill' => $overlay, 'nav-pill-active' => $overlay && $route === 'verticals'])>Verticals</a>
            <a href="{{ route('blog') }}" @class(['nav-link', 'nav-link-active' => str_starts_with($route ?? '', 'blog'), 'nav-pill' => $overlay, 'nav-pill-active' => $overlay && str_starts_with($route ?? '', 'blog')])>Insights</a>
            <a href="{{ route('about') }}" @class(['nav-link', 'nav-link-active' => $route === 'about', 'nav-pill' => $overlay, 'nav-pill-active' => $overlay && $route === 'about'])>About</a>
        </nav>

        <div class="flex items-center gap-2 sm:gap-3">
            <button
                type="button"
                class="theme-toggle"
                @click="toggle()"
                :aria-label="dark ? 'Switch to light mode' : 'Switch to dark mode'"
            >
                <svg x-show="!dark" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
                <svg x-show="dark" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </button>

            <div class="hidden items-center gap-2 lg:flex">
                <a
                    href="{{ $partnerLoginUrl }}"
                    class="rounded-lg px-2.5 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-white/5 dark:hover:text-white"
                >
                    Partner login
                </a>
                <a
                    href="{{ $advertiserLoginUrl }}"
                    class="rounded-lg px-2.5 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-white/5 dark:hover:text-white"
                >
                    Advertiser login
                </a>
                <a href="{{ route('apply') }}" @class(['btn-primary text-sm !px-5 !py-2.5', 'header-cta-pill' => $overlay])>Join Network</a>
            </div>

            <button
                type="button"
                @class([
                    'rounded-xl border p-2.5 text-slate-600 transition lg:hidden dark:text-slate-300',
                    'border-slate-200/80 bg-white/50 hover:bg-white/80' => $overlay,
                    'border-subtle hover:bg-slate-100 dark:hover:bg-white/5' => ! $overlay,
                ])
                @click="mobileOpen = !mobileOpen"
                :aria-expanded="mobileOpen"
                aria-controls="mobile-menu"
                aria-label="Toggle menu"
            >
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="mobileOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    <nav
        id="mobile-menu"
        x-show="mobileOpen"
        x-cloak
        @keydown.escape.window="mobileOpen = false"
        @class([
            'pointer-events-auto border-t border-subtle-5 bg-white/95 px-4 py-4 backdrop-blur-xl lg:hidden dark:border-white/10 dark:bg-surface-900/98',
            'mx-4 mt-2 rounded-2xl border shadow-xl shadow-slate-900/10 dark:shadow-black/40 sm:mx-5' => $overlay,
        ])
        aria-label="Mobile"
    >
        <div class="flex flex-col gap-1">
            @foreach ([
                ['route' => 'advertisers', 'label' => 'Advertisers'],
                ['route' => 'publishers', 'label' => 'Publishers'],
                ['route' => 'offers', 'label' => 'Live offers'],
                ['route' => 'verticals', 'label' => 'Verticals'],
                ['route' => 'blog', 'label' => 'Insights'],
                ['route' => 'about', 'label' => 'About'],
                ['route' => 'contact', 'label' => 'Contact'],
            ] as $item)
                <a
                    href="{{ route($item['route']) }}"
                    @click="mobileOpen = false"
                    @class([
                        'rounded-xl px-4 py-3 font-medium text-slate-900 hover:bg-slate-100 dark:text-white dark:hover:bg-white/10',
                        'nav-link-active' => $route === $item['route'] || ($item['route'] === 'blog' && str_starts_with($route ?? '', 'blog')),
                    ])
                >{{ $item['label'] }}</a>
            @endforeach
            <div class="mt-2 grid grid-cols-2 gap-2 border-t border-subtle-5 pt-3 dark:border-white/10">
                <a
                    href="{{ $partnerLoginUrl }}"
                    @click="mobileOpen = false"
                    class="rounded-xl border border-slate-300 px-3 py-2.5 text-center text-sm font-medium text-slate-800 hover:bg-slate-50 dark:border-white/15 dark:text-white dark:hover:bg-white/10"
                >
                    Partner login
                </a>
                <a
                    href="{{ $advertiserLoginUrl }}"
                    @click="mobileOpen = false"
                    class="rounded-xl border border-slate-300 px-3 py-2.5 text-center text-sm font-medium text-slate-800 hover:bg-slate-50 dark:border-white/15 dark:text-white dark:hover:bg-white/10"
                >
                    Advertiser login
                </a>
            </div>
            <a href="{{ route('apply') }}" @click="mobileOpen = false" class="btn-primary mt-2 text-center">Join Network</a>
        </div>
    </nav>
</header>
