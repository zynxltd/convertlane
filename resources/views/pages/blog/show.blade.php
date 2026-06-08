@php
    $articleUrl = route('blog.show', $post['slug']);
    $publishedIso = \Illuminate\Support\Carbon::parse($post['published_at'])->toIso8601String();
    $ogImage = asset($post['image'] ?? 'images/og-default.jpg');
@endphp

<x-layouts.app
    :title="$post['meta_title'] ?? $post['title']"
    :description="$post['excerpt']"
    :canonical="$articleUrl"
    :image="$ogImage"
    :image-alt="$post['image_alt'] ?? $post['title']"
    type="article"
>
    @push('head')
        <meta name="keywords" content="{{ $post['keywords'] ?? 'affiliate marketing, performance marketing, ConvertLane, '.$post['category'] }}">
        <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $post['title'],
            'description' => $post['excerpt'],
            'image' => [$ogImage],
            'datePublished' => $publishedIso,
            'dateModified' => $publishedIso,
            'author' => [
                '@type' => 'Organization',
                'name' => $post['author'],
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => config('brand.name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset(ltrim(config('brand.logo', '/images/convertlane-logo.png'), '/')),
                ],
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $articleUrl,
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>
        <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Insights',
                    'item' => route('blog'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => $post['title'],
                    'item' => $articleUrl,
                ],
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>
    @endpush

    <x-page-hero :eyebrow="$post['category']">
        <x-slot:prepend>
            <a href="{{ route('blog') }}" class="text-sm font-medium text-brand-600 hover:text-brand-500 dark:text-brand-400 dark:hover:text-brand-300">← Back to insights</a>
        </x-slot:prepend>
        <x-slot:title>{{ $post['title'] }}</x-slot:title>
        <x-slot:subtitle>{{ $post['published_at'] }} · {{ $post['reading_time'] }} min read · {{ $post['author'] }}</x-slot:subtitle>
    </x-page-hero>

    <article class="py-16 lg:py-24">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            @if (! empty($post['image']))
                <x-blog.figure
                    :src="$post['image']"
                    :alt="$post['image_alt'] ?? $post['title']"
                    class="mb-12"
                />
            @endif

            <div class="article-prose max-w-none">
                @includeFirst(['pages.blog.posts.'.$post['slug'], 'pages.blog.posts.fallback'])
            </div>
        </div>
    </article>
</x-layouts.app>
