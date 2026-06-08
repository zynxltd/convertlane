@props(['title', 'summary' => null])

@php
    $updated = \Illuminate\Support\Carbon::parse(config('legal.last_updated'))->format('F j, Y');
@endphp

<x-page-hero eyebrow="Legal">
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:subtitle>
        {{ $summary ?? config('brand.legal_name') . ' · Governed by the laws of ' . config('legal.jurisdiction') }}
    </x-slot:subtitle>
</x-page-hero>

<section class="py-16 lg:py-24">
    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
        <p class="mb-8 text-sm text-muted">Last updated: <time datetime="{{ config('legal.last_updated') }}">{{ $updated }}</time></p>

        <x-legal.nav />

        <div class="article-prose legal-prose max-w-none">
            {{ $slot }}
        </div>

        <x-legal.footer-notice />
    </div>
</section>
