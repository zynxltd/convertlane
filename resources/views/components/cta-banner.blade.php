@props([
    'heading' => 'Ready to scale performance revenue?',
    'sub' => 'Join vetted advertisers and publishers on a network built for conversion quality.',
    'primaryLabel' => 'Apply as Publisher',
    'primaryRoute' => 'apply',
    'secondaryLabel' => 'Talk to Sales',
    'secondaryRoute' => 'contact',
])

<section class="relative overflow-hidden py-20 lg:py-28">
    <div class="absolute inset-0 bg-gradient-to-br from-brand-200/40 via-slate-50 to-accent-200/30 dark:from-brand-600/20 dark:via-surface-950 dark:to-accent-600/10"></div>
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_rgba(6,182,212,0.15),transparent_70%)]"></div>
    <div class="relative mx-auto max-w-4xl px-4 text-center sm:px-6">
        <x-logo variant="mark" size="lg" class="mx-auto" />
        <x-brand-signature align="center" class="mt-6" />
        <h2 class="section-heading mt-8">{{ $heading }}</h2>
        <p class="section-sub mx-auto">{{ $sub }}</p>
        <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
            <a href="{{ route($primaryRoute) }}" class="btn-primary w-full sm:w-auto">{{ $primaryLabel }}</a>
            <a href="{{ route($secondaryRoute) }}" class="btn-secondary w-full sm:w-auto">{{ $secondaryLabel }}</a>
        </div>
    </div>
</section>
