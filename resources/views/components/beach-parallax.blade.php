@props([
    'image' => config('brand.section_parallax_image', '/images/hero/performance-analytics.jpg'),
    'tall' => false,
    'subtle' => false,
])

<section {{ $attributes->class([
    'beach-parallax relative overflow-hidden border-y border-subtle-5',
    'beach-parallax--subtle' => $subtle,
]) }}>
    <div
        class="beach-parallax__bg"
        data-parallax-bg
        style="background-image: url('{{ asset($image) }}')"
        aria-hidden="true"
    ></div>
    <div class="beach-parallax__overlay" aria-hidden="true"></div>
    <div class="relative z-10 {{ $tall ? 'py-24 lg:py-32' : 'py-20 lg:py-28' }}">
        {{ $slot }}
    </div>
</section>
