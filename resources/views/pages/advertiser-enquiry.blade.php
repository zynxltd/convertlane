<x-layouts.app
    title="Advertiser Offer Enquiry"
    description="Enquire about launching a CPA, CPL, or CPS offer on ConvertLane. Our partnerships team responds within one business day."
    :canonical="route('advertiser.enquiry')"
>
    <x-page-hero eyebrow="Advertisers">
        <x-slot:title>Launch an <span class="text-gradient-hero">offer</span></x-slot:title>
        <x-slot:subtitle>Tell us about your brand, vertical, and goals. We will follow up with next steps and IO requirements.</x-slot:subtitle>
    </x-page-hero>

    <section class="py-16 lg:py-24">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
            <form action="{{ route('advertiser.enquiry.store') }}" method="POST" class="relative glass rounded-2xl p-8" novalidate>
                @csrf
                <div class="absolute -left-[9999px] h-0 w-0 overflow-hidden" aria-hidden="true">
                    <label for="website_hp">Leave blank</label>
                    <input type="text" name="website_hp" id="website_hp" value="" tabindex="-1" autocomplete="off">
                </div>

                @if (session('success'))
                    <div class="mb-5 rounded-xl border border-brand-500/30 bg-brand-500/10 px-4 py-3 text-sm text-brand-800 dark:text-brand-200" role="status">
                        {{ session('success') }}
                    </div>
                @endif

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
                        <label for="name" class="form-label">Your name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required autocomplete="name" class="form-input @error('name') border-red-500 @enderror">
                        @error('name')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="company" class="form-label">Company / brand</label>
                        <input type="text" name="company" id="company" value="{{ old('company') }}" required autocomplete="organization" class="form-input @error('company') border-red-500 @enderror">
                        @error('company')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="email" class="form-label">Work email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autocomplete="email" class="form-input @error('email') border-red-500 @enderror">
                        @error('email')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="message" class="form-label">Offer details</label>
                        <textarea name="message" id="message" rows="6" required placeholder="Vertical, target geos, payout model (CPA/CPL/CPS), estimated volume, and launch timeline." class="form-input @error('message') border-red-500 @enderror">{{ old('message', $vertical ? 'Interested in launching an offer in the '.$vertical.' vertical.' : '') }}</textarea>
                        @error('message')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="btn-primary w-full">Submit enquiry</button>
                </div>
            </form>

            <p class="mt-6 text-center text-sm text-muted">
                Already onboarded?
                <a href="{{ route('advertiser.login') }}" class="font-medium text-brand-600 hover:text-brand-500 dark:text-brand-400 dark:hover:text-brand-300">Advertiser login</a>
            </p>
        </div>
    </section>
</x-layouts.app>
