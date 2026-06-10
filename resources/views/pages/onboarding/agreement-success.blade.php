@php
    $isAdvertiser = ($type ?? null) === 'advertiser';
    $title = 'Submitted for approval';
@endphp

<x-layouts.app :title="$title" description="Your agreement has been submitted." robots="noindex, nofollow">
    <x-page-hero eyebrow="Onboarding complete">
        <x-slot:title>Submitted for <span class="text-gradient-hero">approval</span></x-slot:title>
        <x-slot:subtitle>We’ll review your application, questionnaire, and signed agreement. You’ll hear from us within a few business days.</x-slot:subtitle>
    </x-page-hero>

    <section class="py-16 lg:py-24">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
            <div class="glass rounded-2xl p-8">
                <div class="space-y-4 text-sm text-muted">
                    @if (filled($reference ?? null))
                        <p><span class="text-slate-500">Reference:</span> <strong class="font-mono text-heading">{{ $reference }}</strong></p>
                    @endif
                    @if (filled($email ?? null))
                        <p><span class="text-slate-500">Email:</span> <strong class="text-heading">{{ $email }}</strong></p>
                    @endif

                    <ol class="mt-4 list-inside list-decimal space-y-2">
                        <li>ConvertLane reviews your KYB/KYC documents (we may request ID and proof of address).</li>
                        @if ($isAdvertiser)
                            <li>If you chose <strong>prepay</strong>, we’ll send funding instructions before caps open.</li>
                            <li>If you chose <strong>postpay</strong>, our team will run a credit check before approving invoice terms.</li>
                            <li>Once approved, you’ll receive offer IOs and Platform access.</li>
                        @else
                            <li>Once approved, you’ll receive Platform access.</li>
                        @endif
                        <li>Payouts (affiliates) run Net-30 on the 15th for approved conversions.</li>
                    </ol>

                    @if (session('success'))
                        <div class="rounded-xl border border-brand-500/30 bg-brand-500/10 px-4 py-3 text-brand-800 dark:text-brand-200">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('home') }}" class="btn-primary w-full justify-center sm:flex-1">Back to site</a>
                    <a href="{{ route($isAdvertiser ? 'advertiser.login' : 'partner.login') }}" class="btn-secondary w-full justify-center sm:flex-1">
                        {{ $isAdvertiser ? 'Advertiser login' : 'Partner login' }}
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
