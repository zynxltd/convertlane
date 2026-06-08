@props([
    'title' => null,
    'description' => null,
    'canonical' => null,
    'image' => null,
    'imageAlt' => null,
    'type' => 'website',
    'robots' => 'index, follow',
])

<!DOCTYPE html>
<html lang="en-GB" class="bg-slate-50 dark:bg-surface-950">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        (function () {
            if (localStorage.getItem('cl_theme') !== 'light') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    <x-seo
        :title="$title"
        :description="$description"
        :canonical="$canonical"
        :image="$image"
        :image-alt="$imageAlt"
        :type="$type"
        :robots="$robots"
    />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body @class([
    'min-h-screen flex flex-col bg-mesh',
    'has-home-hero' => request()->routeIs('home'),
]) x-data="{ mobileOpen: false, cookieConsent: localStorage.getItem('cl_cookie') === '1', ...theme() }">
    <div class="pointer-events-none fixed inset-0 bg-grid opacity-[0.18] dark:opacity-25" aria-hidden="true"></div>

    <a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded-lg focus:bg-brand-500 focus:px-4 focus:py-2 focus:text-white dark:focus:text-surface-950">Skip to content</a>

    <x-header />

    <main id="main" class="relative flex-1">
        @if (session('success') && ! request()->routeIs('apply.success', 'onboarding.*'))
            <div class="relative border-b border-brand-500/30 bg-brand-500/15 px-4 py-3 text-center text-sm font-medium text-brand-800 dark:text-brand-200" role="status">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="relative border-b border-red-500/30 bg-red-500/15 px-4 py-3 text-center text-sm font-medium text-red-800 dark:text-red-200" role="alert">
                {{ session('error') }}
            </div>
        @endif

        {{ $slot }}
    </main>

    <x-footer />

    <div
        x-show="!cookieConsent"
        x-cloak
        class="fixed inset-x-4 bottom-4 z-50 mx-auto max-w-3xl rounded-2xl border border-slate-200 glass-strong p-4 sm:inset-x-6 dark:border-white/10 dark:bg-surface-900/95 dark:backdrop-blur-xl"
        role="dialog"
        aria-label="Cookie consent"
    >
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm text-slate-600 dark:text-white">
                We use cookies for analytics and to improve your experience.
                <a href="{{ route('privacy') }}" class="font-medium text-brand-600 hover:text-brand-500 dark:text-brand-300 dark:hover:text-brand-200">Privacy Policy</a>
            </p>
            <button
                type="button"
                class="btn-primary shrink-0"
                @click="localStorage.setItem('cl_cookie', '1'); cookieConsent = true"
            >
                Accept
            </button>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
