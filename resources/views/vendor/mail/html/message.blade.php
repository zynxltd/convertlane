@php
    $siteUrl = \App\Support\BrandContact::publicUrl();
    $logoUrl = $siteUrl.config('brand.logo', '/images/convertlane-logo.png');
@endphp
<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="$siteUrl">
<img src="{{ $logoUrl }}" alt="{{ config('app.name') }}" width="160" style="max-width: 160px; height: auto; display: block; margin: 0 auto;">
</x-mail::header>
</x-slot:header>

{{-- Body --}}
{!! $slot !!}

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{!! $subcopy !!}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
© {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
