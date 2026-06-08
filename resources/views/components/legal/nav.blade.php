@php
    $current = request()->route()?->getName();
    $links = [
        ['route' => 'privacy', 'label' => 'Privacy Policy'],
        ['route' => 'terms', 'label' => 'Terms of Service'],
        ['route' => 'affiliate-agreement', 'label' => 'Affiliate Agreement'],
        ['route' => 'advertiser-agreement', 'label' => 'Advertiser Agreement'],
    ];
@endphp

<nav class="legal-nav mb-10 rounded-xl border border-subtle bg-elevated p-4 sm:p-5" aria-label="Legal documents">
    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">On this site</p>
    <ul class="mt-3 flex flex-col gap-2 sm:flex-row sm:flex-wrap sm:gap-x-6 sm:gap-y-2">
        @foreach ($links as $link)
            <li>
                <a
                    href="{{ route($link['route']) }}"
                    @class([
                        'text-sm font-medium transition',
                        'text-brand-600 dark:text-brand-400' => $current === $link['route'],
                        'text-muted hover:text-brand-600 dark:hover:text-brand-400' => $current !== $link['route'],
                    ])
                    @if ($current === $link['route']) aria-current="page" @endif
                >
                    {{ $link['label'] }}
                </a>
            </li>
        @endforeach
    </ul>
</nav>
