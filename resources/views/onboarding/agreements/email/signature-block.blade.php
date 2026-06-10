@php
    $font = 'font-family: Arial, Helvetica, sans-serif;';
    $text = $font.' font-size: 14px; line-height: 1.55; color: #334155; margin: 0 0 10px;';
    $muted = $font.' font-size: 13px; line-height: 1.5; color: #64748b; margin: 0 0 10px;';
    $heading = $font.' font-size: 16px; line-height: 1.4; color: #0f172a; margin: 24px 0 10px; font-weight: 700;';
    $label = $font.' font-size: 14px; line-height: 1.5; color: #0f172a; margin: 0 0 6px;';
    $partnerLabel = ($type ?? 'publisher') === 'advertiser' ? 'Advertiser' : 'Affiliate / Publisher';
    $legalName = config('brand.legal_name');
@endphp

<table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-top: 28px; border-top: 1px solid #e2e8f0;">
    <tr>
        <td style="padding-top: 24px;">
            <h3 style="{{ $heading }}">Signatures</h3>
            <p style="{{ $muted }}">By signing below, both parties agree this agreement is binding.</p>
        </td>
    </tr>
    <tr>
        <td style="padding-top: 16px;">
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td width="50%" valign="top" style="padding-right: 16px;">
                        <p style="{{ $label }} font-weight: 700;">{{ $legalName }}</p>
                        <p style="{{ $muted }} text-transform: uppercase; font-size: 11px; letter-spacing: 0.04em;">Authorised signatory</p>
                        <p style="{{ $muted }} margin-top: 20px; border-bottom: 1px solid #cbd5e1; padding-bottom: 8px;">Pending countersignature</p>
                        <p style="{{ $text }}">Name: —</p>
                        <p style="{{ $text }}">Date: —</p>
                    </td>
                    <td width="50%" valign="top" style="padding-left: 16px;">
                        <p style="{{ $label }} font-weight: 700;">{{ $partnerLabel }}</p>
                        <p style="{{ $muted }} text-transform: uppercase; font-size: 11px; letter-spacing: 0.04em;">Signature</p>
                        <p style="margin: 8px 0 12px;">
                            <img src="{{ $signatureImage }}" alt="Signature of {{ $signerName }}" style="display: block; max-height: 80px; max-width: 100%;">
                        </p>
                        <p style="{{ $text }}">Name: {{ $signerName }}</p>
                        @if (filled($signerTitle ?? null))
                        <p style="{{ $text }}">Title: {{ $signerTitle }}</p>
                        @endif
                        <p style="{{ $text }}">Date: {{ $signedAt->format('j F Y') }}</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
