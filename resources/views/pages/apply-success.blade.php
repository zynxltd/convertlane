@php
    $isAdvertiser = ($type ?? null) === 'advertiser';
    $title = 'Application received';
    $loginRoute = $isAdvertiser ? 'advertiser.login' : 'partner.login';
    $loginLabel = $isAdvertiser ? 'Advertiser login' : 'Partner login';
    $onboardingRoute = $isAdvertiser ? 'onboarding.advertiser' : 'onboarding.publisher';
@endphp

<x-layouts.app :title="$title" description="Your application has been received." robots="noindex, nofollow">
    <x-page-hero eyebrow="Apply">
        <x-slot:title>Application <span class="text-gradient-hero">received</span></x-slot:title>
        <x-slot:subtitle>We review every partner before activation. You’ll hear from us with document requirements and next steps.</x-slot:subtitle>
    </x-page-hero>

    <section class="py-16 lg:py-24">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
            <div class="glass rounded-2xl p-8">
                <h2 class="font-display text-xl font-semibold text-heading">What happens next</h2>
                <div class="mt-5 space-y-4 text-sm text-muted">
                    @if (filled($email ?? null))
                        <p><span class="text-slate-500">Email:</span> <strong class="text-heading">{{ $email }}</strong></p>
                    @endif
                    @if (filled($reference ?? null))
                        <p><span class="text-slate-500">Reference:</span> <strong class="text-heading">{{ $reference }}</strong></p>
                    @endif

                    <ol class="mt-4 list-inside list-decimal space-y-2">
                        <li><strong>Questionnaire</strong> — traffic, company, and compliance details.</li>
                        <li><strong>Agreement</strong> — review terms pre-filled from your answers and sign digitally.</li>
                        <li><strong>Approval</strong> — we review your pack and may request ID/KYB documents before go-live.</li>
                    </ol>

                    <div class="mt-6 rounded-xl border border-brand-500/30 bg-brand-500/10 px-4 py-3 text-sm text-brand-800 dark:text-brand-200">
                        {{ session('success') ?? 'Application received.' }}
                    </div>
                </div>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-stretch">
                    <a href="{{ route($onboardingRoute, ['email' => $email, 'ref' => $reference]) }}" class="btn-primary order-1 w-full justify-center sm:order-2 sm:flex-1">
                        Start onboarding questionnaire
                    </a>
                    <a href="{{ route('home') }}" class="btn-secondary order-2 w-full justify-center sm:order-1 sm:flex-1">
                        Back to site
                    </a>
                    <a href="{{ route($loginRoute) }}" class="btn-secondary order-3 w-full justify-center sm:order-3 sm:flex-1">
                        {{ $loginLabel }}
                    </a>
                </div>

                <p class="mt-6 text-xs text-slate-500">
                    Need help? Email <a class="text-brand-600 hover:text-brand-500 dark:text-brand-400" href="mailto:{{ config('brand.support_email') }}">{{ config('brand.support_email') }}</a>.
                </p>
            </div>
        </div>
    </section>
</x-layouts.app>

