@php
    $partnerLabel = ($type ?? 'publisher') === 'advertiser' ? 'Advertiser' : 'Affiliate / Publisher';
    $legalName = config('brand.legal_name');
@endphp

<section class="mt-8 border-t border-slate-200 pt-6 dark:border-white/10">
    <h3 class="font-semibold text-heading">Signatures</h3>
    <p class="mt-2 text-sm text-muted">By signing below, both parties agree this agreement is binding.</p>

    <div class="mt-6 grid gap-8 sm:grid-cols-2">
        <div>
            <p class="text-sm font-semibold text-heading">{{ $legalName }} (trading as {{ config('brand.name') }})</p>
            <p class="mt-4 text-xs uppercase tracking-wide text-muted">Authorised signatory</p>
            <p class="mt-6 border-b border-slate-300 pb-1 text-sm text-muted dark:border-white/20">Pending countersignature</p>
            <p class="mt-2 text-sm text-body">Name: —</p>
            <p class="text-sm text-body">Date: —</p>
        </div>

        <div>
            <p class="text-sm font-semibold text-heading">{{ $partnerLabel }}</p>
            <p class="mt-4 text-xs uppercase tracking-wide text-muted">Signature</p>
            <div class="mt-2 min-h-[4rem]">
                <img src="{{ $signatureImage }}" alt="Signature of {{ $signerName }}" class="max-h-20">
            </div>
            <p class="mt-2 text-sm text-body">Name: {{ $signerName }}</p>
            @if (filled($signerTitle ?? null))
                <p class="text-sm text-body">Title: {{ $signerTitle }}</p>
            @endif
            <p class="text-sm text-body">Date: {{ $signedAt->format('j F Y') }}</p>
        </div>
    </div>
</section>
