<x-layouts.app title="Compliance queue" description="Internal due diligence queue" robots="noindex, nofollow">
    <section class="py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-brand-400">Internal — DD queue</p>
                    <h1 class="text-3xl font-bold text-heading">Due diligence reviews</h1>
                    <p class="mt-1 text-sm text-slate-500">No tracking access until status = approved + sign-offs complete.</p>
                </div>
                <a href="{{ route('home') }}" class="text-sm text-muted hover:text-slate-900 dark:hover:text-white">← Public site</a>
            </div>

            <form method="GET" class="mt-8 flex flex-wrap gap-3">
                <select name="status" class="rounded-lg border border-subtle bg-elevated px-3 py-2 text-sm text-heading">
                    <option value="">All statuses</option>
                    @foreach ($statuses as $s)
                        <option value="{{ $s }}" @selected(request('status') === $s)>{{ $s }}</option>
                    @endforeach
                </select>
                <select name="type" class="rounded-lg border border-subtle bg-elevated px-3 py-2 text-sm text-heading">
                    <option value="">All types</option>
                    <option value="publisher" @selected(request('type') === 'publisher')>Publisher</option>
                    <option value="advertiser" @selected(request('type') === 'advertiser')>Advertiser</option>
                </select>
                <button type="submit" class="btn-secondary text-sm">Filter</button>
            </form>

            <div class="mt-8 overflow-x-auto rounded-2xl border border-subtle">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-subtle bg-elevated text-muted">
                        <tr>
                            <th class="px-4 py-3">Ref</th>
                            <th class="px-4 py-3">Company</th>
                            <th class="px-4 py-3">Type</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Risk</th>
                            <th class="px-4 py-3">Deadline</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reviews as $review)
                            <tr class="border-b border-subtle-5 hover:bg-slate-100 dark:hover:bg-white/5">
                                <td class="px-4 py-3 font-mono text-brand-300">{{ $review->partner_reference }}</td>
                                <td class="px-4 py-3 text-heading">{{ $review->application?->company }}</td>
                                <td class="px-4 py-3 capitalize">{{ $review->type }}</td>
                                <td class="px-4 py-3">
                                    <span class="rounded-full bg-white/10 px-2 py-0.5 text-xs">{{ $review->status }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    @if ($review->risk_score !== null)
                                        {{ $review->risk_score }} ({{ $review->risk_band }})
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-slate-500">
                                    {{ $review->documents_deadline_at?->format('d M Y') ?? '—' }}
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('compliance.show', $review) }}" class="text-brand-400 hover:underline">Review →</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-4 py-8 text-center text-slate-500">No reviews yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6">{{ $reviews->withQueryString()->links() }}</div>

            <p class="mt-8 text-xs text-slate-600">
                SOPs: <code class="text-muted">docs/due-diligence/</code> ·
                Checklists: publisher-checklist.md / advertiser-checklist.md
            </p>
        </div>
    </section>
</x-layouts.app>
