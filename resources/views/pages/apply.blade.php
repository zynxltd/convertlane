<x-layouts.app
    title="Apply to Join the Network"
    description="Apply to join ConvertLane as a publisher or advertiser. Sole traders, individuals, and companies welcome — reviewed within 3 business days."
    :canonical="route('apply')"
>
    <x-page-hero eyebrow="Apply">
        <x-slot:title>Partner <span class="text-gradient-hero">application</span></x-slot:title>
        <x-slot:subtitle>Strict due diligence applies to every partner. Panel access only after verification.</x-slot:subtitle>
    </x-page-hero>

    <section class="py-16 lg:py-24">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-lg space-y-2 rounded-xl border border-amber-500/30 bg-amber-500/10 px-4 py-3 text-center text-xs leading-relaxed text-amber-800 dark:text-amber-200">
                <p>
                    You can apply as a <strong>company, sole trader, or individual</strong>. You will need proof of identity and either traffic examples (publishers) or product and financial details (advertisers). Company registration is only required where applicable.
                </p>
                <p>
                    Applications using only a free personal email with no verifiable website or trading presence may be declined. Approval may take up to <strong>3 business days</strong>.
                </p>
            </div>

            @php
                $offerInterest = request('offer');
                $offerMeta = $offerInterest
                    ? collect(config('offers.live'))->firstWhere('id', $offerInterest)
                    : null;
            @endphp
            @if ($offerMeta)
                <div class="mx-auto mt-4 max-w-lg rounded-xl border border-brand-500/30 bg-brand-500/10 px-4 py-3 text-center text-sm text-brand-800 dark:text-brand-200">
                    Applying for access to <strong>{{ $offerMeta['name'] }}</strong> ({{ $offerMeta['brand'] }})
                </div>
            @endif

            @if ($errors->any() || session('error'))
                <x-flash-alerts class="mx-auto mt-6 max-w-lg" :show-success="false" />
            @endif

            <form
                action="{{ route('apply.store') }}"
                method="POST"
                class="relative mt-10 glass rounded-2xl p-8"
                x-data="{ type: '{{ old('type', request('type', 'publisher')) }}', submitting: false }"
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
                    <p class="text-sm font-medium text-white">Submitting your application…</p>
                </div>
                @error('type')<p class="mb-4 text-sm text-red-400">{{ $message }}</p>@enderror
                <div class="mb-8 flex rounded-xl border border-subtle p-1">
                    <button type="button" @click="type = 'publisher'" :class="type === 'publisher' ? 'bg-brand-500 text-surface-900' : 'text-muted'" class="flex-1 rounded-lg py-2.5 text-sm font-semibold transition">Publisher</button>
                    <button type="button" @click="type = 'advertiser'" :class="type === 'advertiser' ? 'bg-brand-500 text-surface-900' : 'text-muted'" class="flex-1 rounded-lg py-2.5 text-sm font-semibold transition">Advertiser</button>
                </div>
                <input type="hidden" name="type" x-model="type">

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-body">First name</label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required minlength="2" maxlength="100" autocomplete="given-name" class="form-input focus:border-brand-500 focus:outline-none @error('first_name') border-red-500 @enderror">
                        @error('first_name')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-body">Last name</label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required minlength="2" maxlength="100" autocomplete="family-name" class="form-input focus:border-brand-500 focus:outline-none @error('last_name') border-red-500 @enderror">
                        @error('last_name')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="mt-5">
                    <label for="email" class="block text-sm font-medium text-body">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required maxlength="255" autocomplete="email" class="form-input focus:border-brand-500 focus:outline-none @error('email') border-red-500 @enderror">
                    @error('email')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                </div>

                <div class="mt-5">
                    <label for="company" class="block text-sm font-medium text-body">Legal company name</label>
                    <input type="text" name="company" id="company" value="{{ old('company') }}" required minlength="2" maxlength="255" autocomplete="organization" class="form-input focus:border-brand-500 focus:outline-none @error('company') border-red-500 @enderror">
                    @error('company')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                </div>

                <div class="mt-5">
                    <label for="company_number" class="block text-sm font-medium text-body">Company registration number</label>
                    <input type="text" name="company_number" id="company_number" value="{{ old('company_number') }}" required minlength="2" maxlength="50" placeholder="e.g. Companies House number" class="form-input focus:border-brand-500 focus:outline-none @error('company_number') border-red-500 @enderror">
                    @error('company_number')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                </div>

                <div class="mt-5">
                    <label for="website" class="block text-sm font-medium text-body">Website</label>
                    <input type="text" name="website" id="website" value="{{ old('website') }}" required maxlength="500" inputmode="url" autocomplete="url" placeholder="yourcompany.com" class="form-input focus:border-brand-500 focus:outline-none @error('website') border-red-500 @enderror">
                    @error('website')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                </div>

                <x-country-select
                    name="country"
                    id="country"
                    :value="old('country')"
                    label="Registered country"
                    required
                    class="mt-5 focus:border-brand-500 focus:outline-none"
                />

                <div class="mt-5" x-show="type === 'publisher'" x-cloak>
                    <label for="traffic_sources" class="block text-sm font-medium text-body">Traffic sources <span class="text-red-400">*</span></label>
                    <textarea
                        name="traffic_sources"
                        id="traffic_sources"
                        rows="3"
                        minlength="10"
                        maxlength="2000"
                        placeholder="SEO, paid social, email, native..."
                        class="form-input focus:border-brand-500 focus:outline-none @error('traffic_sources') border-red-500 @enderror"
                        x-bind:disabled="type !== 'publisher'"
                    >{{ old('traffic_sources') }}</textarea>
                    @error('traffic_sources')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                </div>

                <div class="mt-5">
                    <label for="monthly_volume" class="block text-sm font-medium text-body">Est. monthly volume</label>
                    <select name="monthly_volume" id="monthly_volume" required class="form-input focus:border-brand-500 focus:outline-none @error('monthly_volume') border-red-500 @enderror">
                        <option value="">Select range</option>
                        @foreach (['< £5k', '£5k – £25k', '£25k – £100k', '£100k+'] as $range)
                            <option value="{{ $range }}" @selected(old('monthly_volume') === $range)>{{ $range }}</option>
                        @endforeach
                    </select>
                    @error('monthly_volume')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                </div>

                <div class="mt-5">
                    <label for="message" class="block text-sm font-medium text-body">Additional info</label>
                    <textarea name="message" id="message" rows="4" maxlength="5000" class="form-input focus:border-brand-500 focus:outline-none @error('message') border-red-500 @enderror">{{ old('message', $offerMeta ? 'Offer interest: '.$offerMeta['id'].' ('.$offerMeta['name'].')' : '') }}</textarea>
                    @error('message')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                </div>

                <label class="mt-6 flex items-start gap-3 text-sm text-muted">
                    <input type="checkbox" name="terms" value="1" required class="mt-1 rounded border-slate-300 dark:border-white/20 bg-elevated-muted text-brand-500 focus:ring-brand-500">
                    <span>I agree to the <a href="{{ route('terms') }}" class="text-brand-400 underline">Terms</a>, <a href="{{ route('privacy') }}" class="text-brand-400 underline">Privacy Policy</a>, and applicable <a href="{{ route('affiliate-agreement') }}" class="text-brand-400 underline">Partner Agreement</a>.</span>
                </label>
                @error('terms')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror

                <button type="submit" class="btn-primary mt-8 w-full disabled:pointer-events-none disabled:opacity-60" :disabled="submitting">
                    <span x-show="!submitting">Submit application</span>
                    <span x-show="submitting" x-cloak>Please wait…</span>
                </button>
            </form>
        </div>
    </section>
</x-layouts.app>
