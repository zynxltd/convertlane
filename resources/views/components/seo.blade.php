@props([
    'title' => null,
    'description' => null,
    'canonical' => null,
    'image' => null,
    'imageAlt' => null,
    'type' => 'website',
    'robots' => 'index, follow',
])

@php
    $brand = config('brand.name');
    $legalName = config('brand.legal_name');
    $defaultDescription = config('brand.description');
    $pageTitle = $title ? "{$title} | {$brand}" : "{$brand} | " . config('brand.descriptor');
    $metaDescription = $description ?? $defaultDescription;
    $canonicalUrl = $canonical ?? url()->current();
    $ogImage = $image ?? asset('images/og-default.jpg');
    $ogImageAlt = $imageAlt ?? $brand;

    $orgSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => $brand,
        'legalName' => $legalName,
        'url' => config('brand.url'),
        'logo' => asset(ltrim(config('brand.logo', '/images/convertlane-logo.png'), '/')),
        'description' => $defaultDescription,
        'email' => config('brand.contact_email'),
        'sameAs' => array_values(config('brand.social')),
    ];

    if (filled(config('brand.company_number'))) {
        $orgSchema['identifier'] = [
            '@type' => 'PropertyValue',
            'propertyID' => 'Companies House',
            'value' => config('brand.company_number'),
        ];
    }

    if (filled(config('brand.address'))) {
        $orgSchema['address'] = [
            '@type' => 'PostalAddress',
            'streetAddress' => '11 Brendon Close',
            'addressLocality' => 'Grantham',
            'addressRegion' => 'Lincolnshire',
            'postalCode' => 'NG31 8FU',
            'addressCountry' => 'GB',
        ];
    }
@endphp

<title>{{ $pageTitle }}</title>
<meta name="description" content="{{ Str::limit($metaDescription, 160) }}">
<link rel="canonical" href="{{ $canonicalUrl }}">
<meta name="robots" content="{{ $robots }}">
<meta name="theme-color" content="#0b1220">

<meta property="og:type" content="{{ $type }}">
<meta property="og:site_name" content="{{ $brand }}">
<meta property="og:locale" content="en_GB">
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ Str::limit($metaDescription, 200) }}">
<meta property="og:url" content="{{ $canonicalUrl }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:image:alt" content="{{ $ogImageAlt }}">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ Str::limit($metaDescription, 200) }}">
<meta name="twitter:image" content="{{ $ogImage }}">

<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="{{ config('brand.logo', '/images/convertlane-logo.png') }}">

<script type="application/ld+json">
{!! json_encode($orgSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
