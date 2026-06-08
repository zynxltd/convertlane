@php
    $isEdit = $offer->exists;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $isEdit ? 'Edit' : 'Add' }} offer — CMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 dark:bg-surface-950">
    <div class="mx-auto max-w-2xl px-4 py-10">
        <a href="{{ route('admin.offers.index') }}" class="text-sm font-medium text-brand-600 dark:text-brand-400">← All offers</a>
        <h1 class="mt-4 font-display text-2xl font-bold text-heading">{{ $isEdit ? 'Edit offer' : 'Add offer' }}</h1>

        <form method="POST" action="{{ $isEdit ? route('admin.offers.update', $offer) : route('admin.offers.store') }}" class="mt-8 space-y-5" novalidate>
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            @if ($errors->any())
                <div class="rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-700 dark:text-red-300">
                    <ul class="list-inside list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <label class="form-label" for="name">Offer name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $offer->name) }}" required maxlength="255" class="form-input @error('name') border-red-500 @enderror">
                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="form-label" for="slug">Slug (URL id)</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $offer->slug) }}" maxlength="120" pattern="[a-z0-9\-]*" placeholder="auto-from-name" class="form-input @error('slug') border-red-500 @enderror">
                @error('slug')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="form-label" for="brand">Brand</label>
                    <input type="text" name="brand" id="brand" value="{{ old('brand', $offer->brand) }}" required class="form-input">
                </div>
                <div>
                    <label class="form-label" for="brand_slug">Brand slug</label>
                    <input type="text" name="brand_slug" id="brand_slug" value="{{ old('brand_slug', $offer->brand_slug) }}" class="form-input">
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="form-label" for="vertical">Vertical</label>
                    <select name="vertical" id="vertical" required class="form-input">
                        @foreach ($verticals as $v)
                            <option value="{{ $v['slug'] }}" @selected(old('vertical', $offer->vertical) === $v['slug'])>{{ $v['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label" for="model">Model</label>
                    <select name="model" id="model" required class="form-input">
                        @foreach (['CPA', 'CPL', 'CPS', 'Hybrid'] as $m)
                            <option value="{{ $m }}" @selected(old('model', $offer->model) === $m)>{{ $m }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="form-label" for="payout">Payout</label>
                    <input type="text" name="payout" id="payout" value="{{ old('payout', $offer->payout) }}" required class="form-input" placeholder="£120">
                </div>
                <div>
                    <label class="form-label" for="event">Payable event</label>
                    <input type="text" name="event" id="event" value="{{ old('event', $offer->event) }}" required class="form-input">
                </div>
            </div>

            <div>
                <label class="form-label" for="geos">Geos (comma-separated)</label>
                <input type="text" name="geos" id="geos" value="{{ old('geos', implode(', ', $offer->geos ?? [])) }}" required class="form-input" placeholder="GB, IE">
            </div>

            <div>
                <label class="form-label" for="traffic">Traffic types (comma-separated)</label>
                <input type="text" name="traffic" id="traffic" value="{{ old('traffic', implode(', ', $offer->traffic ?? [])) }}" class="form-input" placeholder="SEO, Native">
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="form-label" for="cap">Cap</label>
                    <input type="text" name="cap" id="cap" value="{{ old('cap', $offer->cap) }}" class="form-input">
                </div>
                <div>
                    <label class="form-label" for="status">Status</label>
                    <select name="status" id="status" class="form-input">
                        @foreach (['live', 'limited', 'private'] as $s)
                            <option value="{{ $s }}" @selected(old('status', $offer->status ?? 'live') === $s)>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="form-label" for="description">Description</label>
                <textarea name="description" id="description" rows="3" class="form-input">{{ old('description', $offer->description) }}</textarea>
            </div>

            <div>
                <label class="form-label" for="sort_order">Sort order</label>
                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $offer->sort_order ?? 0) }}" min="0" class="form-input max-w-[8rem]">
            </div>

            <label class="flex items-center gap-3">
                <input type="checkbox" name="in_house" value="1" @checked(old('in_house', $offer->in_house)) class="rounded border-slate-300 text-brand-500">
                <span class="text-sm text-body">In-house brand</span>
            </label>

            <label class="flex items-center gap-3">
                <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $offer->is_published)) class="rounded border-slate-300 text-brand-500">
                <span class="text-sm font-medium text-body">Published on website</span>
            </label>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="btn-primary">Save</button>
                @if ($isEdit)
                    <button type="submit" formaction="{{ route('admin.offers.destroy', $offer) }}" formmethod="POST" class="btn-secondary" onclick="return confirm('Delete this offer?')">
                        @csrf
                        @method('DELETE')
                        Delete
                    </button>
                @endif
            </div>
        </form>
    </div>
</body>
</html>
