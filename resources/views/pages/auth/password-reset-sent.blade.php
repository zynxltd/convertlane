@php
    $isAdvertiser = $portal === 'advertiser';
    $loginRoute = $isAdvertiser ? 'advertiser.login' : 'partner.login';
@endphp

<x-layouts.app title="Check your email" description="Password reset request received." robots="noindex, nofollow">
    <section class="py-20 lg:py-28">
        <div class="mx-auto max-w-md px-4 text-center sm:px-6 lg:px-8">
            <div class="glass rounded-2xl p-8">
                <h1 class="font-display text-2xl font-semibold text-heading">Check your email</h1>
                <p class="mt-4 text-sm text-muted">
                    @if (filled($email))
                        If an account exists for <strong class="text-heading">{{ $email }}</strong>, we sent a new temporary password and sign-in link.
                    @else
                        If an account exists for that email, we sent a new temporary password and sign-in link.
                    @endif
                </p>
                <p class="mt-4 text-sm text-muted">
                    Did not receive it? Check spam, or contact {{ config('brand.support_email') }}.
                </p>
                <a href="{{ route($loginRoute) }}" class="btn-primary mt-8 inline-block">Back to sign in</a>
            </div>
        </div>
    </section>
</x-layouts.app>
