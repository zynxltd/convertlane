<footer class="relative border-t border-subtle bg-elevated-muted">
    <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-brand-500/50 to-transparent"></div>
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-12 md:grid-cols-2 lg:grid-cols-4">
            <div class="lg:col-span-1">
                <x-logo variant="stacked" size="md" />
                <p class="mt-5 max-w-xs text-sm leading-relaxed text-muted">
                    {{ config('brand.signature') }}
                </p>
                <div class="mt-6 flex gap-3">
                    <a href="{{ config('brand.social.linkedin') }}" class="flex h-9 w-9 items-center justify-center rounded-lg border border-subtle text-muted transition hover:border-brand-500/30 hover:text-brand-400" rel="noopener" aria-label="LinkedIn">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                    <a href="{{ config('brand.social.twitter') }}" class="flex h-9 w-9 items-center justify-center rounded-lg border border-subtle text-muted transition hover:border-brand-500/30 hover:text-brand-400" rel="noopener" aria-label="X">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                </div>
            </div>
            <div>
                <h3 class="font-display text-xs font-bold uppercase tracking-wider text-slate-500">Partners</h3>
                <ul class="mt-4 space-y-3 text-sm">
                    <li><a href="{{ route('advertisers') }}" class="text-muted transition hover:text-brand-400">For Advertisers</a></li>
                    <li><a href="{{ route('publishers') }}" class="text-body hover:text-brand-400">For Publishers</a></li>
                    <li><a href="{{ route('offers') }}" class="text-muted transition hover:text-brand-400">Live offers</a></li>
                    <li><a href="{{ route('apply') }}" class="text-muted transition hover:text-brand-400">Apply</a></li>
                    <li><a href="{{ route('partner.login') }}" class="text-muted transition hover:text-brand-400">Partner login</a></li>
                    <li><a href="{{ route('advertiser.login') }}" class="text-muted transition hover:text-brand-400">Advertiser login</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-display text-xs font-bold uppercase tracking-wider text-slate-500">Company</h3>
                <ul class="mt-4 space-y-3 text-sm">
                    <li><a href="{{ route('about') }}" class="text-muted transition hover:text-brand-400">About</a></li>
                    <li><a href="{{ route('verticals') }}" class="text-muted transition hover:text-brand-400">Verticals</a></li>
                    <li><a href="{{ route('blog') }}" class="text-muted transition hover:text-brand-400">Insights</a></li>
                    <li><a href="{{ route('contact') }}" class="text-muted transition hover:text-brand-400">Contact</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-display text-xs font-bold uppercase tracking-wider text-slate-500">Legal</h3>
                <ul class="mt-4 space-y-3 text-sm">
                    <li><a href="{{ route('privacy') }}" class="text-muted transition hover:text-brand-400">Privacy</a></li>
                    <li><a href="{{ route('terms') }}" class="text-muted transition hover:text-brand-400">Terms</a></li>
                    <li><a href="{{ route('affiliate-agreement') }}" class="text-muted transition hover:text-brand-400">Affiliate Agreement</a></li>
                    <li><a href="{{ route('advertiser-agreement') }}" class="text-muted transition hover:text-brand-400">Advertiser Agreement</a></li>
                </ul>
            </div>
        </div>
        <div class="mt-12 flex flex-col gap-4 border-t border-subtle-5 pt-8 text-sm text-slate-500 sm:flex-row sm:items-center sm:justify-between">
            <p>&copy; {{ date('Y') }} {{ config('brand.name') }}</p>
            <a href="mailto:{{ config('brand.contact_email') }}" class="font-medium text-muted hover:text-brand-400">{{ config('brand.contact_email') }}</a>
        </div>
    </div>
</footer>
