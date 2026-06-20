@props([
    'geos' => [],
    'size' => 'md',
])

@php
    $sizeClass = match ($size) {
        'sm' => 'h-5 w-5',
        'lg' => 'h-7 w-7',
        default => 'h-6 w-6',
    };
@endphp

<div {{ $attributes->merge(['class' => 'flex flex-wrap items-center gap-1.5']) }}>
    @forelse ($geos as $geo)
        @php
            $url = \App\Support\CountryFlag::roundelUrl((string) $geo);
            $name = \App\Support\CountryFlag::name((string) $geo);
        @endphp
        @if ($url)
            <img
                src="{{ $url }}"
                alt="{{ $name }}"
                title="{{ $name }}"
                class="{{ $sizeClass }} shrink-0"
                loading="lazy"
                decoding="async"
            >
        @elseif (trim((string) $geo) !== '' && (string) $geo !== '—')
            <span class="inline-flex {{ $sizeClass }} items-center justify-center rounded-full bg-slate-100 px-1.5 text-[10px] font-semibold text-muted dark:bg-white/10" title="{{ $name }}">{{ $geo }}</span>
        @endif
    @empty
        <span class="text-muted">—</span>
    @endforelse
</div>
