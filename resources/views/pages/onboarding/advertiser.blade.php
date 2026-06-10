@php
    $title = 'Advertiser onboarding';
@endphp

<x-layouts.app :title="$title" description="Advertiser onboarding questionnaire." robots="noindex, nofollow">
    <x-page-hero eyebrow="Onboarding">
        <x-slot:title>Advertiser <span class="text-gradient-hero">questionnaire</span></x-slot:title>
        <x-slot:subtitle>
            Complete this to start due diligence. You must be able to provide government-issued photo ID for the authorised signatory and UBOs (where applicable).
        </x-slot:subtitle>
    </x-page-hero>

    <section class="py-16 lg:py-24">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
            <div class="glass rounded-2xl p-8">
                <x-flash-alerts class="mb-5" :showSuccess="false" :showError="false" :showValidation="true" />

                @if (session('success'))
                    <div class="space-y-4 text-sm text-muted">
                        <p>We’ll review your answers and follow up with the due diligence document request. You don’t need to submit this form again.</p>
                        <a href="{{ route('home') }}" class="btn-secondary inline-flex">Back to site</a>
                    </div>
                @else
                    <form
                        action="{{ route('onboarding.advertiser.store') }}"
                        method="POST"
                        class="relative"
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
                            <p class="text-sm font-medium text-white">Submitting…</p>
                        </div>

                        <div class="space-y-5">
                            <div class="grid gap-5 sm:grid-cols-2">
                                <div>
                                    <label class="form-label" for="partner_reference">Reference (optional)</label>
                                    <input class="form-input" id="partner_reference" name="partner_reference" value="{{ old('partner_reference', $prefill['partner_reference'] ?? '') }}" placeholder="DD-A-00001">
                                </div>
                                <div>
                                    <label class="form-label" for="contact_email">Contact email</label>
                                    <input class="form-input @error('contact_email') border-red-500 @enderror" id="contact_email" name="contact_email" type="email" required value="{{ old('contact_email', $prefill['contact_email'] ?? '') }}" autocomplete="email">
                                    @error('contact_email')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div class="grid gap-5 sm:grid-cols-2">
                                <div>
                                    <label class="form-label" for="contact_name">Authorised signatory</label>
                                    <input class="form-input @error('contact_name') border-red-500 @enderror" id="contact_name" name="contact_name" required value="{{ old('contact_name', $prefill['contact_name'] ?? '') }}" placeholder="Full name and title">
                                    @error('contact_name')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="form-label" for="entity_type">Entity type</label>
                                    <select class="form-input @error('entity_type') border-red-500 @enderror" id="entity_type" name="entity_type" required>
                                        @php $et = old('entity_type', 'company'); @endphp
                                        <option value="company" @selected($et === 'company')>Registered company</option>
                                        <option value="sole_trader" @selected($et === 'sole_trader')>Sole trader</option>
                                        <option value="individual" @selected($et === 'individual')>Individual (rare)</option>
                                    </select>
                                    @error('entity_type')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div class="grid gap-5 sm:grid-cols-2">
                                <div>
                                    <label class="form-label" for="company_name">Legal company name</label>
                                    <input class="form-input @error('company_name') border-red-500 @enderror" id="company_name" name="company_name" value="{{ old('company_name', $prefill['company_name'] ?? '') }}" required>
                                    @error('company_name')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="form-label" for="company_number">Company number</label>
                                    <input class="form-input" id="company_number" name="company_number" value="{{ old('company_number', $prefill['company_number'] ?? '') }}">
                                </div>
                            </div>

                            <div class="grid gap-5 sm:grid-cols-2">
                                <div>
                                    <label class="form-label" for="website">Company website</label>
                                    <input class="form-input @error('website') border-red-500 @enderror" id="website" name="website" required value="{{ old('website', $prefill['website'] ?? '') }}" placeholder="example.com">
                                    @error('website')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                                </div>
                                <x-country-select name="country" id="country" label="Country" :value="$prefill['country'] ?? null" required />
                            </div>

                            <div class="grid gap-5 sm:grid-cols-2">
                                <div>
                                    <label class="form-label" for="vertical">Vertical</label>
                                    <input class="form-input @error('vertical') border-red-500 @enderror" id="vertical" name="vertical" value="{{ old('vertical', $prefill['vertical'] ?? '') }}" placeholder="Finance / iGaming / Health / SaaS / E-com">
                                    @error('vertical')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="form-label" for="postback_url">Postback / tracking spec</label>
                                    <input class="form-input @error('postback_url') border-red-500 @enderror" id="postback_url" name="postback_url" value="{{ old('postback_url', $prefill['postback_url'] ?? '') }}" placeholder="URL or brief spec">
                                    @error('postback_url')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div>
                                <label class="form-label" for="product_description">Product description</label>
                                <textarea class="form-input" id="product_description" name="product_description" rows="3" maxlength="2000">{{ old('product_description', $prefill['product_description'] ?? '') }}</textarea>
                            </div>

                            <div>
                                <label class="form-label" for="landing_pages">Landing page URLs (all geos)</label>
                                <textarea class="form-input @error('landing_pages') border-red-500 @enderror" id="landing_pages" name="landing_pages" rows="3" maxlength="2000" placeholder="One per line if possible.">{{ old('landing_pages', $prefill['landing_pages'] ?? '') }}</textarea>
                                @error('landing_pages')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="form-label" for="notes">Anything else we should know?</label>
                                <textarea class="form-input" id="notes" name="notes" rows="4" maxlength="5000">{{ old('notes', $prefill['notes'] ?? '') }}</textarea>
                            </div>

                            <label class="mt-2 flex items-start gap-3 text-sm text-muted">
                                <input type="checkbox" name="confirm_id_required" value="1" required class="mt-1 rounded border-slate-300 dark:border-white/20 bg-elevated-muted text-brand-500 focus:ring-brand-500" @checked(old('confirm_id_required'))>
                                <span>I confirm we can provide government-issued photo ID for the authorised signatory (and UBOs where applicable), plus required KYB/financial documents.</span>
                            </label>
                            @error('confirm_id_required')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror

                            <button type="submit" class="btn-primary mt-6 w-full disabled:pointer-events-none disabled:opacity-60" :disabled="submitting">
                                <span x-show="!submitting">Submit questionnaire</span>
                                <span x-show="submitting" x-cloak>Please wait…</span>
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </section>
</x-layouts.app>
