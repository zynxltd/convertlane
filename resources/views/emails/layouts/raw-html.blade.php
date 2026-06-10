<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('app.name') }}</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f8fafc;">
@php
    $siteUrl = \App\Support\BrandContact::publicUrl();
    $logoUrl = $siteUrl.config('brand.logo', '/images/convertlane-logo.png');
@endphp
<table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background-color: #f8fafc; padding: 24px 0;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; max-width: 600px; background-color: #ffffff; border: 1px solid #e2e8f0;">
                <tr>
                    <td style="padding: 24px 28px 12px; text-align: center;">
                        <a href="{{ $siteUrl }}" style="text-decoration: none;">
                            <img src="{{ $logoUrl }}" alt="{{ config('app.name') }}" width="160" style="max-width: 160px; height: auto; display: block; margin: 0 auto;">
                        </a>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px 28px 28px; font-family: Arial, Helvetica, sans-serif;">
                        {!! $content !!}
                    </td>
                </tr>
                <tr>
                    <td style="padding: 16px 28px 24px; border-top: 1px solid #e2e8f0; font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 1.5; color: #94a3b8; text-align: center;">
                        © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
