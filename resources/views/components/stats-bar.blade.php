<section class="relative border-y border-subtle-5 bg-gradient-to-r from-slate-100 via-brand-100/50 to-slate-100 py-14 dark:from-surface-900 dark:via-brand-900/20 dark:to-surface-900" aria-label="Network statistics">
    <div class="mx-auto grid max-w-7xl grid-cols-1 gap-8 px-4 sm:grid-cols-3 sm:px-6 lg:px-8">
        @foreach (config('brand.stats') as $stat)
            <div class="text-center">
                <p class="font-display text-4xl font-bold tracking-tight text-transparent bg-gradient-to-b from-slate-900 to-brand-600 bg-clip-text sm:text-5xl dark:from-white dark:to-brand-300">{{ $stat['value'] }}</p>
                <p class="mt-2 text-sm font-medium text-slate-500">{{ $stat['label'] }}</p>
            </div>
        @endforeach
    </div>
</section>
