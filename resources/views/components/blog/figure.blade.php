@props([
    'src',
    'alt',
    'caption' => null,
    'wide' => false,
])

<figure {{ $attributes->class([$wide ? 'my-10 -mx-4 sm:mx-0' : 'my-10']) }}>
    <div class="photo-frame overflow-hidden">
        <img
            src="{{ str_starts_with($src, 'http') ? $src : asset($src) }}"
            alt="{{ $alt }}"
            class="img-cover aspect-[16/9] w-full"
            loading="lazy"
            decoding="async"
        >
    </div>
    @if ($caption)
        <figcaption class="mt-3 text-center text-sm text-muted">{{ $caption }}</figcaption>
    @endif
</figure>
