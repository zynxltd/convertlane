@php
    $isAdvertiser = $type === 'advertiser';
    $title = $isAdvertiser ? 'Sign advertiser agreement' : 'Sign affiliate agreement';
    $partnerLabel = $isAdvertiser ? 'Advertiser' : 'Affiliate';
    $questionnaireRoute = $isAdvertiser ? 'onboarding.advertiser' : 'onboarding.publisher';
    $startOnSignStep = $errors->any();
@endphp

<x-layouts.app :title="$title" description="Review and sign your ConvertLane partner agreement." robots="noindex, nofollow">
    <x-page-hero eyebrow="Onboarding · Step 3 of 3">
        <x-slot:title>Review &amp; <span class="text-gradient-hero">sign agreement</span></x-slot:title>
        <x-slot:subtitle>
            Confirm your details, then read and sign the agreement to submit for approval.
        </x-slot:subtitle>
    </x-page-hero>

    <section class="py-16 lg:py-24">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="mb-6 flex flex-wrap gap-2 text-xs font-medium text-muted">
                <span class="rounded-full bg-elevated-muted px-3 py-1">1 Apply</span>
                <span class="rounded-full bg-elevated-muted px-3 py-1">2 Questionnaire</span>
                <span class="rounded-full bg-brand-500/20 px-3 py-1 text-brand-700 dark:text-brand-300">3 Agreement</span>
            </div>

            <div class="glass rounded-2xl p-8">
                <x-flash-alerts class="mb-5" />

                <div
                    x-data="onboardingAgreement({ startOnSign: @js($startOnSignStep) })"
                    class="relative"
                >
                    {{-- Step indicators --}}
                    <div class="mb-8 flex gap-3 text-sm">
                        <button
                            type="button"
                            class="flex flex-1 items-center gap-2 rounded-xl border px-4 py-3 text-left transition"
                            :class="step === 'confirm' ? 'border-brand-500/40 bg-brand-500/10 text-heading' : 'border-subtle bg-elevated-muted text-muted'"
                            @click="step = 'confirm'"
                        >
                            <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full text-xs font-bold" :class="step === 'confirm' ? 'bg-brand-500 text-white dark:text-surface-950' : 'bg-slate-200 text-slate-600 dark:bg-white/10 dark:text-slate-300'">1</span>
                            <span><span class="block font-medium">Confirm details</span><span class="text-xs text-muted">From your questionnaire</span></span>
                        </button>
                        <button
                            type="button"
                            class="flex flex-1 items-center gap-2 rounded-xl border px-4 py-3 text-left transition"
                            :class="step === 'sign' ? 'border-brand-500/40 bg-brand-500/10 text-heading' : 'border-subtle bg-elevated-muted text-muted'"
                            :disabled="!detailsConfirmed && step !== 'sign'"
                            @click="detailsConfirmed || step === 'sign' ? step = 'sign' : null"
                        >
                            <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full text-xs font-bold" :class="step === 'sign' ? 'bg-brand-500 text-white dark:text-surface-950' : 'bg-slate-200 text-slate-600 dark:bg-white/10 dark:text-slate-300'">2</span>
                            <span><span class="block font-medium">Sign agreement</span><span class="text-xs text-muted">Read, sign &amp; submit</span></span>
                        </button>
                    </div>

                    {{-- Step 1: Confirm details --}}
                    <div x-show="step === 'confirm'" x-cloak class="space-y-6">
                        <div>
                            <h2 class="font-display text-lg font-semibold text-heading">Confirm your details</h2>
                            <p class="mt-1 text-sm text-muted">Check everything matches your questionnaire. If something is wrong, go back and update it before signing.</p>
                        </div>

                        <div class="rounded-xl border border-subtle bg-elevated-muted px-5 py-2">
                            <x-onboarding.details-summary
                                :type="$type"
                                :questionnaire="$questionnaire"
                                :reference="$review->partner_reference"
                            />
                        </div>

                        <label class="flex items-start gap-3 text-sm text-body">
                            <input type="checkbox" x-model="detailsConfirmed" class="mt-1 rounded border-slate-300 dark:border-white/20 dark:bg-surface-900">
                            <span>I confirm the details above are correct.</span>
                        </label>

                        <div class="flex flex-col gap-3 sm:flex-row">
                            <a href="{{ route($questionnaireRoute, ['email' => $questionnaire['contact_email'] ?? '', 'ref' => $review->partner_reference]) }}" class="btn-secondary w-full justify-center sm:flex-1">
                                Edit questionnaire
                            </a>
                            <button type="button" class="btn-primary w-full justify-center sm:flex-1 disabled:pointer-events-none disabled:opacity-50" :disabled="!detailsConfirmed" @click="step = 'sign'">
                                Continue to agreement
                            </button>
                        </div>
                    </div>

                    {{-- Step 2: Agreement + signature --}}
                    <form
                        x-show="step === 'sign'"
                        x-cloak
                        action="{{ route($agreementRoute) }}"
                        method="POST"
                        class="relative space-y-8"
                        novalidate
                        @submit="prepareSubmit($event)"
                        :aria-busy="submitting"
                    >
                        @csrf
                        <input type="hidden" name="partner_reference" value="{{ $review->partner_reference }}">
                        <input type="hidden" name="contact_email" value="{{ $questionnaire['contact_email'] ?? '' }}">
                        <input type="hidden" name="signature_data" x-ref="signatureInput" value="{{ old('signature_data') }}">

                        <div>
                            <div class="flex items-center justify-between gap-4">
                                <h2 class="font-display text-lg font-semibold text-heading">{{ $partnerLabel }} agreement</h2>
                                <button type="button" class="text-sm text-brand-600 hover:text-brand-500 dark:text-brand-400" @click="step = 'confirm'">← Review details</button>
                            </div>
                            <p class="mt-1 text-sm text-muted">Scroll through the full agreement below, then sign at the bottom.</p>
                        </div>

                        <div class="agreement-panel legal-prose">
                            {!! $agreementBody !!}
                        </div>

                        <p class="text-sm text-muted">
                            Full legal text:
                            <a href="{{ route($fullAgreementRoute) }}" target="_blank" rel="noopener" class="text-brand-600 hover:text-brand-500 dark:text-brand-400">
                                {{ $isAdvertiser ? 'Advertiser Agreement' : 'Affiliate Agreement' }}
                            </a>
                            ·
                            <a href="{{ route('terms') }}" target="_blank" rel="noopener" class="text-brand-600 hover:text-brand-500 dark:text-brand-400">Terms of Service</a>
                        </p>

                        @if ($isAdvertiser)
                            <fieldset class="space-y-3">
                                <legend class="form-label">Billing preference</legend>
                                <p class="text-sm text-muted">Choose how you will fund campaigns. Postpay requires credit approval.</p>
                                <div class="grid gap-3 sm:grid-cols-2">
                                    <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-subtle bg-elevated-muted p-4 @error('billing_model') border-red-500 @enderror">
                                        <input type="radio" name="billing_model" value="prepay" class="mt-1" @checked(old('billing_model', 'prepay') === 'prepay') required>
                                        <span>
                                            <span class="block font-medium text-heading">Prepay</span>
                                            <span class="mt-1 block text-sm text-muted">Funds received before caps open. Recommended for new advertisers.</span>
                                        </span>
                                    </label>
                                    <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-subtle bg-elevated-muted p-4 @error('billing_model') border-red-500 @enderror">
                                        <input type="radio" name="billing_model" value="postpay" class="mt-1" @checked(old('billing_model') === 'postpay')>
                                        <span>
                                            <span class="block font-medium text-heading">Postpay</span>
                                            <span class="mt-1 block text-sm text-muted">Invoice Net-15/30 after credit check. Subject to approval.</span>
                                        </span>
                                    </label>
                                </div>
                                @error('billing_model')<p class="text-sm text-red-400">{{ $message }}</p>@enderror
                            </fieldset>
                        @endif

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label class="form-label" for="signer_name">Full name (as signatory)</label>
                                <input class="form-input @error('signer_name') border-red-500 @enderror" id="signer_name" name="signer_name" required value="{{ old('signer_name', $questionnaire['contact_name'] ?? '') }}">
                                @error('signer_name')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="form-label" for="signer_title">Title / role</label>
                                <input class="form-input" id="signer_title" name="signer_title" value="{{ old('signer_title') }}" placeholder="Director, Owner, etc.">
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between gap-4">
                                <label class="form-label mb-0">Digital signature</label>
                                <button type="button" class="text-sm text-brand-600 hover:text-brand-500 dark:text-brand-400" @click="clear()">Clear</button>
                            </div>
                            <p class="mt-1 text-sm text-muted">Sign with your mouse or finger in the box below.</p>
                            <div class="signature-frame mt-3">
                                <canvas
                                    x-ref="canvas"
                                    class="signature-canvas"
                                    width="800"
                                    height="160"
                                    @mousedown="start($event)"
                                    @mousemove="draw($event)"
                                    @mouseup="end()"
                                    @mouseleave="end()"
                                    @touchstart.prevent="start($event)"
                                    @touchmove.prevent="draw($event)"
                                    @touchend.prevent="end()"
                                ></canvas>
                            </div>
                            @error('signature_data')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                        </div>

                        <div class="space-y-3 text-sm text-body">
                            <label class="flex items-start gap-3">
                                <input type="checkbox" name="accept_agreement" value="1" required class="mt-1 rounded border-slate-300 dark:border-white/20 dark:bg-surface-900" @checked(old('accept_agreement'))>
                                <span>I have read and agree to the {{ $partnerLabel }} Agreement above (including the full agreement linked).</span>
                            </label>
                            @error('accept_agreement')<p class="text-sm text-red-400">{{ $message }}</p>@enderror

                            <label class="flex items-start gap-3">
                                <input type="checkbox" name="accept_terms" value="1" required class="mt-1 rounded border-slate-300 dark:border-white/20 dark:bg-surface-900" @checked(old('accept_terms'))>
                                <span>I agree to the <a href="{{ route('terms') }}" target="_blank" rel="noopener" class="text-brand-600 dark:text-brand-400">Terms of Service</a> and <a href="{{ route('privacy') }}" target="_blank" rel="noopener" class="text-brand-600 dark:text-brand-400">Privacy Policy</a>.</span>
                            </label>
                            @error('accept_terms')<p class="text-sm text-red-400">{{ $message }}</p>@enderror
                        </div>

                        <div
                            x-show="submitting"
                            x-cloak
                            class="absolute inset-0 z-10 flex flex-col items-center justify-center gap-3 rounded-2xl bg-slate-950/90 text-white backdrop-blur-sm dark:bg-black/80"
                            role="status"
                        >
                            <svg class="h-10 w-10 animate-spin text-brand-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <p class="text-sm font-medium">Submitting for approval…</p>
                        </div>

                        <button type="submit" class="btn-primary w-full disabled:pointer-events-none disabled:opacity-60" :disabled="submitting">
                            <span x-show="!submitting">Submit for approval</span>
                            <span x-show="submitting" x-cloak>Please wait…</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('onboardingAgreement', ({ startOnSign = false }) => ({
                    step: startOnSign ? 'sign' : 'confirm',
                    detailsConfirmed: startOnSign,
                    submitting: false,
                    drawing: false,
                    hasInk: false,
                    init() {
                        this.$nextTick(() => this.initCanvas());
                    },
                    initCanvas() {
                        const canvas = this.$refs.canvas;
                        if (!canvas) return;
                        const ctx = canvas.getContext('2d');
                        const dark = document.documentElement.classList.contains('dark');
                        ctx.strokeStyle = dark ? '#f8fafc' : '#0f172a';
                        ctx.lineWidth = 2;
                        ctx.lineCap = 'round';
                        ctx.lineJoin = 'round';
                    },
                    pointer(event) {
                        const canvas = this.$refs.canvas;
                        const rect = canvas.getBoundingClientRect();
                        const clientX = event.touches ? event.touches[0].clientX : event.clientX;
                        const clientY = event.touches ? event.touches[0].clientY : event.clientY;
                        return {
                            x: (clientX - rect.left) * (canvas.width / rect.width),
                            y: (clientY - rect.top) * (canvas.height / rect.height),
                        };
                    },
                    start(event) {
                        this.drawing = true;
                        const ctx = this.$refs.canvas.getContext('2d');
                        const { x, y } = this.pointer(event);
                        ctx.beginPath();
                        ctx.moveTo(x, y);
                    },
                    draw(event) {
                        if (!this.drawing) return;
                        const ctx = this.$refs.canvas.getContext('2d');
                        const { x, y } = this.pointer(event);
                        ctx.lineTo(x, y);
                        ctx.stroke();
                        this.hasInk = true;
                    },
                    end() {
                        this.drawing = false;
                        if (this.hasInk && this.$refs.signatureInput) {
                            this.$refs.signatureInput.value = this.$refs.canvas.toDataURL('image/png');
                        }
                    },
                    clear() {
                        const canvas = this.$refs.canvas;
                        if (!canvas) return;
                        canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
                        if (this.$refs.signatureInput) {
                            this.$refs.signatureInput.value = '';
                        }
                        this.hasInk = false;
                    },
                    prepareSubmit(event) {
                        if (!this.$refs.signatureInput?.value) {
                            event.preventDefault();
                            alert('Please draw your signature before submitting.');
                            return;
                        }
                        this.submitting = true;
                    },
                }));
            });
        </script>
    @endpush
</x-layouts.app>
