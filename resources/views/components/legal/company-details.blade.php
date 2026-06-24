@php
    $legalName = config('brand.legal_name');
    $brand = config('brand.name');
    $companyNumber = config('brand.company_number');
    $registered = config('brand.registered');
    $address = config('brand.address');
@endphp

<p>
    <strong>{{ $legalName }}</strong>
    @if (filled($companyNumber))
        (company number {{ $companyNumber }})
    @endif
    @if (filled($registered))
        , registered in {{ $registered }}.
    @endif
    @if ($brand !== $legalName)
        <strong>{{ $brand }}</strong> is a trading name of {{ $legalName }}.
    @endif
</p>
@if (filled($address))
    <p><strong>Registered office:</strong> {{ $address }}</p>
@endif
