<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Offers — CMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 dark:bg-surface-950">
    <div class="mx-auto max-w-5xl px-4 py-10">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="font-display text-2xl font-bold text-heading">Offers</h1>
                <p class="mt-1 text-sm text-muted">Published offers appear on the public catalogue.</p>
            </div>
            <a href="{{ route('admin.offers.create') }}" class="btn-primary">Add offer</a>
        </div>

        @if (session('status'))
            <p class="mt-4 rounded-lg border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-800 dark:text-emerald-200">{{ session('status') }}</p>
        @endif

        @if ($offers->isEmpty())
            <p class="mt-10 rounded-xl border border-dashed border-subtle px-6 py-12 text-center text-muted">No offers yet. The public page will show an empty state until you publish one.</p>
        @else
            <div class="mt-8 overflow-hidden rounded-xl border border-subtle bg-elevated">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-subtle bg-slate-50 dark:bg-elevated-muted">
                        <tr>
                            <th class="px-4 py-3 font-semibold text-heading">Offer</th>
                            <th class="px-4 py-3 font-semibold text-heading">Vertical</th>
                            <th class="px-4 py-3 font-semibold text-heading">Status</th>
                            <th class="px-4 py-3 font-semibold text-heading">Published</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($offers as $offer)
                            <tr class="border-b border-subtle-5 last:border-0">
                                <td class="px-4 py-3">
                                    <p class="font-medium text-heading">{{ $offer->name }}</p>
                                    <p class="text-xs text-muted">{{ $offer->brand }} · {{ $offer->slug }}</p>
                                </td>
                                <td class="px-4 py-3 text-muted">{{ $offer->vertical }}</td>
                                <td class="px-4 py-3 text-muted">{{ $offer->status }}</td>
                                <td class="px-4 py-3">
                                    @if ($offer->is_published)
                                        <span class="text-emerald-600 dark:text-emerald-400">Yes</span>
                                    @else
                                        <span class="text-muted">No</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('admin.offers.edit', $offer) }}" class="font-medium text-brand-600 hover:text-brand-500 dark:text-brand-400">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <p class="mt-8 text-sm text-muted">
            <a href="{{ route('offers') }}" class="text-brand-600 hover:underline dark:text-brand-400">View public offers page</a>
        </p>
    </div>
</body>
</html>
