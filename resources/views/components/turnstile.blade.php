@props(['class' => ''])

@if (filled(config('services.turnstile.site_key')))
    @once
        @push('head')
            <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
        @endpush
    @endonce

    <div {{ $attributes->merge(['class' => $class]) }}>
        <div
            class="cf-turnstile"
            data-sitekey="{{ config('services.turnstile.site_key') }}"
            data-theme="auto"
        ></div>
    </div>
    @error('cf-turnstile-response')
        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
    @enderror
@endif
