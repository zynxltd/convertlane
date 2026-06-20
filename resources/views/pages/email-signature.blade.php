@php
    $siteUrl = \App\Support\BrandContact::publicUrl();
    $logoUrl = $siteUrl.config('brand.logo', '/images/convertlane-logo.png');
    $name = request('name', 'Tom Jameson');
    $role = request('role', 'Partnerships');
    $email = request('email', config('brand.contact_email', 'partners@convertlane.co.uk'));
@endphp
<!DOCTYPE html>
<html lang="en-GB">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Email signature — {{ config('brand.name') }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            padding: 48px 24px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Arial, sans-serif;
            background: #f1f5f9;
            color: #0f172a;
        }
        .wrap { max-width: 640px; margin: 0 auto; }
        h1 { font-size: 1.25rem; margin: 0 0 8px; }
        .hint {
            margin: 0 0 24px;
            font-size: 14px;
            line-height: 1.5;
            color: #64748b;
        }
        .hint code {
            font-size: 13px;
            background: #e2e8f0;
            padding: 2px 6px;
            border-radius: 4px;
        }
        .preview {
            background: #fff;
            border: 2px dashed #cbd5e1;
            border-radius: 8px;
            padding: 28px 32px;
            cursor: text;
            user-select: all;
        }
        .preview:focus { outline: 2px solid #0891b2; outline-offset: 2px; }
        .steps {
            margin-top: 28px;
            padding: 20px 24px;
            background: #fff;
            border-radius: 8px;
            font-size: 14px;
            line-height: 1.6;
            color: #475569;
        }
        .steps ol { margin: 0; padding-left: 1.25rem; }
        .steps li { margin-bottom: 6px; }
    </style>
</head>
<body>
    <div class="wrap">
        <h1>{{ config('brand.name') }} email signature</h1>
        <p class="hint">
            Select the signature below (click inside the dashed box, then Cmd+A / Ctrl+A), copy, and paste into
            Gmail → Settings → Signature. Optional: <code>?name=Your+Name&amp;role=Partnerships</code>
        </p>

        <div class="preview" id="signature" tabindex="0">
            <table cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; line-height: 1.45; color: #334155;">
                <tr>
                    <td style="padding-bottom: 12px;">
                        <a href="{{ $siteUrl }}" target="_blank" style="text-decoration: none;">
                            <img src="{{ $logoUrl }}" alt="{{ config('brand.name') }}" width="160" style="display: block; border: 0; max-width: 160px; height: auto;">
                        </a>
                    </td>
                </tr>
                <tr>
                    <td style="padding-bottom: 2px;">
                        <strong style="font-size: 14px; color: #0b1220;">{{ $name }}</strong>
                    </td>
                </tr>
                <tr>
                    <td style="color: #64748b; padding-bottom: 10px;">
                        {{ $role }} · {{ config('brand.legal_name') }}
                    </td>
                </tr>
                <tr>
                    <td style="padding-bottom: 2px;">
                        <a href="mailto:{{ $email }}" style="color: #0891b2; text-decoration: none;">{{ $email }}</a>
                    </td>
                </tr>
                <tr>
                    <td style="padding-bottom: 12px;">
                        <a href="{{ $siteUrl }}" style="color: #0891b2; text-decoration: none;">convertlane.co.uk</a>
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 11px; color: #94a3b8; letter-spacing: 0.04em; text-transform: uppercase;">
                        {{ config('brand.tagline') }} · {{ config('brand.descriptor') }}
                    </td>
                </tr>
            </table>
        </div>

        <div class="steps">
            <strong>Gmail steps</strong>
            <ol>
                <li>Click inside the dashed box above</li>
                <li>Select all (Cmd+A / Ctrl+A) and copy (Cmd+C / Ctrl+C)</li>
                <li>Gmail → Settings → General → Signature → Create new</li>
                <li>Paste into the signature editor</li>
                <li>Set as default for new emails and replies → Save changes</li>
            </ol>
        </div>
    </div>
</body>
</html>
