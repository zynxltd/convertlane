<x-layouts.app :title="'DD '.$review->partner_reference" robots="noindex, nofollow">
    <section class="py-12">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <a href="{{ route('compliance.index') }}" class="text-sm text-brand-400">← Queue</a>

            <div class="mt-4 flex flex-wrap items-start justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-heading font-mono">{{ $review->partner_reference }}</h1>
                    <p class="text-muted">{{ $review->application?->company }} · {{ ucfirst($review->type) }}</p>
                </div>
                <div class="text-right">
                    <span class="rounded-lg bg-brand-500/20 px-3 py-1 text-sm font-semibold text-brand-300">{{ $review->status }}</span>
                    @if ($review->canGoLive())
                        <p class="mt-1 text-xs text-green-400">✓ Cleared for go-live</p>
                    @else
                        <p class="mt-1 text-xs text-amber-400">Not cleared for go-live</p>
                    @endif
                </div>
            </div>

            <div class="mt-8 grid gap-6 lg:grid-cols-2">
                <div class="glass rounded-2xl p-6 space-y-3 text-sm">
                    <h2 class="font-semibold text-heading">Application</h2>
                    <p><span class="text-slate-500">Contact:</span> {{ $review->application?->first_name }} {{ $review->application?->last_name }}</p>
                    <p><span class="text-slate-500">Email:</span> {{ $review->application?->email }}</p>
                    <p><span class="text-slate-500">Website:</span> {{ $review->application?->website ?? '—' }}</p>
                    <p><span class="text-slate-500">Company #:</span> {{ $review->application?->company_number ?? '—' }}</p>
                    <p><span class="text-slate-500">Volume:</span> {{ $review->application?->monthly_volume ?? '—' }}</p>
                    @if ($review->application?->traffic_sources)
                        <p><span class="text-slate-500">Traffic:</span> {{ $review->application->traffic_sources }}</p>
                    @endif
                </div>

                <div class="glass rounded-2xl p-6 space-y-2 text-sm">
                    <h2 class="font-semibold text-heading">Sign-offs</h2>
                    <p>Sanctions: {{ $review->sanctions_clear === true ? '✓ Clear' : ($review->sanctions_clear === false ? '✗ Fail' : '—') }}</p>
                    <p>PEP: {{ $review->pep_clear === true ? '✓' : ($review->pep_clear === false ? '✗' : '—') }}</p>
                    <p>Compliance: {{ $review->compliance_signed_off ? '✓ '.$review->compliance_signed_by : '—' }}</p>
                    <p>AM: {{ $review->am_signed_off ? '✓ '.$review->am_signed_by : '—' }}</p>
                    @if ($review->type === 'advertiser')
                        <p>Finance: {{ $review->finance_approved ? '✓ '.$review->finance_approved_by : '—' }}</p>
                        <p>Exposure limit: £{{ number_format($review->exposure_limit_gbp ?? 0, 2) }}</p>
                        <p>Payment terms: {{ $review->payment_terms ?? '—' }}</p>
                    @endif
                    <p>Risk: {{ $review->risk_score ?? '—' }} {{ $review->risk_band ? "({$review->risk_band})" : '' }}</p>
                    <p>Docs complete: {{ $review->documents_complete ? 'Yes' : 'No' }}</p>
                    <p>Deadline: {{ $review->documents_deadline_at?->format('d M Y H:i') ?? '—' }}</p>
                </div>
            </div>

            @if ($review->internal_notes)
                <div class="mt-6 glass rounded-2xl p-6 text-sm text-body">
                    <h2 class="font-semibold text-heading">Internal notes</h2>
                    <p class="mt-2 whitespace-pre-wrap">{{ $review->internal_notes }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('compliance.update', $review) }}" class="mt-8 glass rounded-2xl p-6 space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-body">Your name (audit trail)</label>
                    <input type="text" name="actor" required class="form-input max-w-xs" placeholder="e.g. Jane Compliance">
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-body">Risk score</label>
                        <input type="number" name="risk_score" min="0" max="200" value="{{ $review->risk_score }}" class="form-input">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" name="action" value="score" class="btn-secondary w-full">Update score</button>
                    </div>
                </div>

                <div class="flex flex-wrap gap-4 text-sm">
                    <label class="flex items-center gap-2"><input type="checkbox" name="sanctions_clear" value="1" @checked($review->sanctions_clear) class="rounded"> Sanctions clear</label>
                    <label class="flex items-center gap-2"><input type="checkbox" name="pep_clear" value="1" @checked($review->pep_clear) class="rounded"> PEP clear</label>
                    <label class="flex items-center gap-2"><input type="checkbox" name="documents_complete" value="1" @checked($review->documents_complete) class="rounded"> Documents complete</label>
                    <label class="flex items-center gap-2"><input type="checkbox" name="compliance_signed_off" value="1" @checked($review->compliance_signed_off) class="rounded"> Compliance sign-off</label>
                    <label class="flex items-center gap-2"><input type="checkbox" name="am_signed_off" value="1" @checked($review->am_signed_off) class="rounded"> AM sign-off</label>
                    @if ($review->type === 'advertiser')
                        <label class="flex items-center gap-2"><input type="checkbox" name="finance_approved" value="1" @checked($review->finance_approved) class="rounded"> Finance sign-off</label>
                    @endif
                </div>

                @if ($review->type === 'advertiser')
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm text-body">Exposure limit (GBP)</label>
                            <input type="number" step="0.01" name="exposure_limit_gbp" value="{{ $review->exposure_limit_gbp }}" class="form-input">
                        </div>
                        <div>
                            <label class="block text-sm text-body">Payment terms</label>
                            <input type="text" name="payment_terms" value="{{ $review->payment_terms }}" placeholder="Prepay 90d / Net-15" class="form-input">
                        </div>
                    </div>
                @endif

                <div>
                    <label class="block text-sm text-body">Tracking partner ID (post-approval only)</label>
                    <input type="text" name="affise_partner_id" value="{{ $review->affise_partner_id }}" class="form-input max-w-sm">
                </div>

                <div>
                    <label class="block text-sm text-body">Internal notes</label>
                    <textarea name="internal_notes" rows="3" class="form-input">{{ $review->internal_notes }}</textarea>
                </div>

                <div class="border-t border-subtle pt-6 grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm text-body">Change status</label>
                        <select name="to_status" class="form-input">
                            @foreach (config('compliance.statuses') as $s)
                                <option value="{{ $s }}" @selected($review->status === $s)>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-body">Notes (required for reject / on_hold / enhanced_dd)</label>
                        <input type="text" name="notes" class="form-input">
                    </div>
                    <button type="submit" name="action" value="transition" class="btn-primary sm:col-span-2">Update status</button>
                </div>

                <div class="border-t border-subtle pt-6 flex flex-wrap gap-4 items-end">
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm text-red-400">Reject</label>
                        <select name="rejection_code" class="form-input border-red-500/30">
                            <option value="">Reason code</option>
                            @foreach ($rejectCodes as $code => $label)
                                <option value="{{ $code }}">{{ $code }} — {{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" name="action" value="reject" class="rounded-xl bg-red-600 px-6 py-2.5 text-sm font-semibold text-heading hover:bg-red-500">Reject partner</button>
                </div>

                <button type="submit" name="action" value="signoff" class="btn-secondary w-full">Save sign-offs & notes</button>
            </form>

            <div class="mt-10">
                <h2 class="text-lg font-semibold text-heading">Audit log</h2>
                <ul class="mt-4 space-y-2 text-sm">
                    @foreach ($review->auditLogs as $log)
                        <li class="glass rounded-lg px-4 py-3">
                            <span class="text-slate-500">{{ $log->created_at->format('Y-m-d H:i') }}</span>
                            · <span class="text-brand-300">{{ $log->actor }}</span>
                            · {{ $log->from_status ?? '—' }} → <strong class="text-heading">{{ $log->to_status }}</strong>
                            @if ($log->notes)<span class="text-muted"> — {{ $log->notes }}</span>@endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
</x-layouts.app>
