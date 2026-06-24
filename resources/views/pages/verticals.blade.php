<x-layouts.app title="Verticals" description="Explore ConvertLane affiliate offers across finance, iGaming, health, SaaS, e-commerce, and dating verticals.">
    <x-page-hero eyebrow="Verticals">
        <x-slot:title>Specialist teams per <span class="text-gradient-hero">industry</span></x-slot:title>
        <x-slot:subtitle>Compliance workflows and publisher recruitment tailored to each vertical, not one-size-fits-all.</x-slot:subtitle>
    </x-page-hero>

    <section class="py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-10 md:grid-cols-2">
                @foreach (config('brand.verticals') as $vertical)
                    @php $img = \App\Support\BrandImages::vertical($vertical['slug']); @endphp
                    <article id="{{ $vertical['slug'] }}" class="overflow-hidden rounded-2xl border border-subtle bg-elevated shadow-xl scroll-mt-24">
                        <div class="relative h-56">
                            <img src="{{ asset($img) }}" alt="{{ $vertical['name'] }}" class="img-cover" loading="lazy">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent"></div>
                            <h2 class="absolute bottom-4 left-6 font-display text-2xl font-bold text-white">{{ $vertical['name'] }}</h2>
                        </div>
                        <div class="p-6">
                            <x-vertical-icon :icon="$vertical['icon']" class="h-8 w-8 text-brand-500" />
                            <p class="mt-4 text-muted leading-relaxed">{{ $vertical['description'] }}</p>
                            <a href="{{ route('advertiser.enquiry') }}?vertical={{ $vertical['slug'] }}" class="mt-6 inline-flex text-sm font-semibold text-brand-600 hover:text-brand-500 dark:text-brand-400">
                                Launch in this vertical →
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.app>
