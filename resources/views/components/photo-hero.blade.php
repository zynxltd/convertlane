{{-- @deprecated Use <x-page-hero> — kept for cached views --}}
@props([
    'page' => null,
    'eyebrow' => null,
    'showLogo' => false,
    'showDashboard' => false,
])

<x-page-hero :eyebrow="$eyebrow" :show-logo="$showLogo" :show-dashboard="$showDashboard">
    @isset($title)
        <x-slot:title>{!! $title !!}</x-slot:title>
    @endisset
    @isset($subtitle)
        <x-slot:subtitle>{!! $subtitle !!}</x-slot:subtitle>
    @endisset
    @isset($meta)
        <x-slot:meta>{{ $meta }}</x-slot:meta>
    @endisset
    @isset($actions)
        <x-slot:actions>{{ $actions }}</x-slot:actions>
    @endisset
</x-page-hero>
