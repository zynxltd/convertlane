<x-layouts.app title="Contact" description="Contact ConvertLane partnerships, compliance, or billing. We respond within one business day.">
    <x-page-hero eyebrow="Contact">
        <x-slot:title>Get in <span class="text-gradient-hero">touch</span></x-slot:title>
        <x-slot:subtitle>Partnerships, compliance, or billing — we're here to help.</x-slot:subtitle>
    </x-page-hero>

    <section class="py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-2">
                <div>
                    <dl class="space-y-6 text-sm">
                        <div>
                            <dt class="font-semibold text-slate-500">Contact</dt>
                            <dd><a href="mailto:{{ config('brand.contact_email') }}" class="text-brand-400">{{ config('brand.contact_email') }}</a></dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-slate-500">Address</dt>
                            <dd class="text-muted">{{ config('brand.address') }}</dd>
                        </div>
                    </dl>
                </div>

                <form action="{{ route('contact.store') }}" method="POST" class="relative glass rounded-2xl p-8" novalidate>
                    @csrf
                    <div class="absolute -left-[9999px] h-0 w-0 overflow-hidden" aria-hidden="true">
                        <input type="text" name="_trap" id="contact_trap" value="" tabindex="-1" autocomplete="new-password">
                    </div>
                    <div class="space-y-5">
                        @if ($errors->any())
                            <div class="rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-700 dark:text-red-300" role="alert">
                                <ul class="list-inside list-disc space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div>
                            <label for="name" class="block text-sm font-medium text-body">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required minlength="2" maxlength="200" autocomplete="name" class="form-input focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 @error('name') border-red-500 @enderror">
                            @error('name')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-body">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required maxlength="255" autocomplete="email" class="form-input focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 @error('email') border-red-500 @enderror">
                            @error('email')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-medium text-body">Subject</label>
                            <select name="subject" id="subject" required class="form-input focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 @error('subject') border-red-500 @enderror">
                                <option value="">Select a subject</option>
                                @foreach (['Partnerships', 'Publisher support', 'Advertiser support', 'Compliance', 'Billing & payouts', 'Technical / tracking', 'Other'] as $subject)
                                    <option value="{{ $subject }}" @selected(old('subject') === $subject)>{{ $subject }}</option>
                                @endforeach
                            </select>
                            @error('subject')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-body">Message</label>
                            <textarea name="message" id="message" rows="5" required minlength="10" maxlength="5000" class="form-input focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                            @error('message')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                        </div>
                        <button type="submit" class="btn-primary w-full">Send message</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-layouts.app>
