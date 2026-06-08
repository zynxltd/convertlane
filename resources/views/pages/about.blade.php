<x-layouts.app title="About" description="ConvertLane is a UK-based performance affiliate network. Meet our team and compliance standards.">
    <x-page-hero :eyebrow="config('brand.descriptor')" show-logo>
        <x-slot:title>
            A performance network built on <span class="text-gradient-hero">vetting, not volume</span>
        </x-slot:title>
        <x-slot:subtitle>{{ config('brand.origin') }}</x-slot:subtitle>
        <x-slot:meta>
            <dl>
                <div>
                    <dt>Legal entity</dt>
                    <dd>{{ config('brand.legal_name') }}</dd>
                </div>
                <div>
                    <dt>Registered</dt>
                    <dd>{{ config('brand.registered') }}</dd>
                </div>
                <div>
                    <dt>Based in</dt>
                    <dd>United Kingdom</dd>
                </div>
            </dl>
        </x-slot:meta>
    </x-page-hero>

    <section class="py-16 lg:py-24">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="space-y-6 text-center text-muted leading-relaxed">
                <p>
                    Most networks optimise for sign-up count. That floods advertisers with junk traffic and burns publisher relationships when payouts slip.
                </p>
                <p>
                    ConvertLane is built the other way: every partner is reviewed before they get tracking links, offers are configured from signed IOs, and payouts are reconciled to approved stats on a published schedule.
                </p>
            </div>
        </div>
    </section>

    @if (config('brand.show_team'))
        <x-team-grid />
    @endif

    <x-cta-banner />
</x-layouts.app>
