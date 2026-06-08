@php
    $isAdvertiser = $portal === 'advertiser';
    $title = $isAdvertiser ? 'Reset advertiser password' : 'Reset partner password';
    $description = $isAdvertiser
        ? 'Request a new password for your ConvertLane advertiser account.'
        : 'Request a new password for your ConvertLane partner account.';
    $resetRoute = $isAdvertiser ? 'advertiser.password.request.store' : 'partner.password.request.store';
    $loginRoute = $isAdvertiser ? 'advertiser.login' : 'partner.login';
@endphp

<x-layouts.app :title="$title" :description="$description" robots="noindex, nofollow">
    <x-page-hero :eyebrow="$isAdvertiser ? 'Advertisers' : 'Partners'">
        <x-slot:title>Reset your <span class="text-gradient-hero">password</span></x-slot:title>
        <x-slot:subtitle>
            Enter the email on your approved account. We will email you a new temporary password.
        </x-slot:subtitle>
    </x-page-hero>

    <section class="py-16 lg:py-24">
        <div class="mx-auto max-w-md px-4 sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="mb-5 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-700 dark:text-red-300" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <form
                action="{{ route($resetRoute) }}"
                method="POST"
                class="glass relative rounded-2xl p-8"
                novalidate
                x-data="{ submitting: false }"
                @submit="submitting = true"
                :aria-busy="submitting"
            >
                @csrf

                <div
                    x-show="submitting"
                    x-cloak
                    class="absolute inset-0 z-10 flex flex-col items-center justify-center gap-3 rounded-2xl bg-slate-950/90 text-white backdrop-blur-sm"
                    role="status"
                    aria-live="polite"
                >
                    <svg class="h-10 w-10 animate-spin text-brand-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="text-sm font-medium text-white">Resetting your password…</p>
                </div>

                @if ($errors->any())
                    <div class="mb-5 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-700 dark:text-red-300" role="alert">
                        <ul class="list-inside list-disc space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="space-y-5">
                    <div>
                        <label for="email" class="form-label">Account email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autocomplete="email" autofocus class="form-input @error('email') border-red-500 @enderror">
                        @error('email')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="btn-primary w-full disabled:pointer-events-none disabled:opacity-60" :disabled="submitting">
                        <span x-show="!submitting">Reset password</span>
                        <span x-show="submitting" x-cloak>Please wait…</span>
                    </button>
                </div>
            </form>

            <p class="mt-6 text-center text-sm text-muted">
                <a href="{{ route($loginRoute) }}" class="font-medium text-brand-600 hover:text-brand-500 dark:text-brand-400 dark:hover:text-brand-300">Back to sign in</a>
            </p>
        </div>
    </section>
</x-layouts.app>
