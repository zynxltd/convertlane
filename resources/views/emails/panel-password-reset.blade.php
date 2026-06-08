<x-mail::message>
# {{ $portalLabel }} password reset

Your password for **{{ config('app.name') }}** has been reset.

**Temporary password:** `{{ $temporaryPassword }}`

Sign in here: [{{ $loginUrl }}]({{ $loginUrl }})

Please change this password after you log in to your dashboard.

If you did not request a reset, contact us at {{ config('brand.support_email') }} immediately.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
