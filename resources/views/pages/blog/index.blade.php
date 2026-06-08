<x-layouts.app
    title="Insights"
    description="Affiliate marketing strategy, compliance, and offer optimisation insights from the ConvertLane team."
    :canonical="route('blog')"
>
    @push('head')
        <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Blog',
            'name' => config('brand.name').' Insights',
            'url' => route('blog'),
            'description' => 'Affiliate marketing strategy, compliance, and performance guides from ConvertLane.',
            'publisher' => [
                '@type' => 'Organization',
                'name' => config('brand.name'),
                'url' => config('brand.url'),
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>
    @endpush

    <x-page-hero eyebrow="Insights">
        <x-slot:title>Insights & <span class="text-gradient-hero">guides</span></x-slot:title>
        <x-slot:subtitle>Strategy, compliance, and performance marketing guides.</x-slot:subtitle>
    </x-page-hero>

    <section class="py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($posts as $post)
                    <article class="glass flex flex-col overflow-hidden rounded-2xl">
                        @if (! empty($post['image']))
                            <a href="{{ route('blog.show', $post['slug']) }}" class="block overflow-hidden">
                                <img
                                    src="{{ asset($post['image']) }}"
                                    alt="{{ $post['image_alt'] ?? $post['title'] }}"
                                    class="aspect-[16/10] w-full object-cover transition duration-300 hover:scale-[1.02]"
                                    loading="lazy"
                                    decoding="async"
                                >
                            </a>
                        @endif
                        <div class="flex flex-1 flex-col p-6">
                            <span class="text-xs font-medium text-brand-600 dark:text-brand-400">{{ $post['category'] }}</span>
                            <h2 class="mt-2 text-lg font-semibold text-heading">
                                <a href="{{ route('blog.show', $post['slug']) }}" class="hover:text-brand-500 dark:hover:text-brand-300">{{ $post['title'] }}</a>
                            </h2>
                            <p class="mt-2 flex-1 text-sm leading-relaxed text-muted">{{ $post['excerpt'] }}</p>
                        </div>
                        <div class="border-t border-subtle-5 px-6 py-4 text-xs text-muted">
                            {{ $post['published_at'] }} · {{ $post['reading_time'] }} min read
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.app>
