<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class OfferController extends Controller
{
    public function index(): View
    {
        return view('admin.offers.index', [
            'offers' => Offer::query()->orderBy('sort_order')->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.offers.form', [
            'offer' => new Offer,
            'verticals' => config('brand.verticals', []),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['name']);

        Offer::query()->create($data);

        return redirect()->route('admin.offers.index')
            ->with('status', 'Offer created.');
    }

    public function edit(Offer $offer): View
    {
        return view('admin.offers.form', [
            'offer' => $offer,
            'verticals' => config('brand.verticals', []),
        ]);
    }

    public function update(Request $request, Offer $offer): RedirectResponse
    {
        $data = $this->validated($request);

        if (isset($data['slug'])) {
            $data['slug'] = $this->uniqueSlug($data['slug'], $offer->id);
        }

        $offer->update($data);

        return redirect()->route('admin.offers.index')
            ->with('status', 'Offer updated.');
    }

    public function destroy(Offer $offer): RedirectResponse
    {
        $offer->delete();

        return redirect()->route('admin.offers.index')
            ->with('status', 'Offer deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    protected function validated(Request $request): array
    {
        $data = $request->validate([
            'slug' => ['nullable', 'string', 'max:120', 'regex:/^[a-z0-9\-]+$/'],
            'name' => ['required', 'string', 'max:255'],
            'brand' => ['required', 'string', 'max:255'],
            'brand_slug' => ['nullable', 'string', 'max:120'],
            'in_house' => ['boolean'],
            'vertical' => ['required', 'string', 'max:50'],
            'model' => ['required', 'string', 'max:20'],
            'payout' => ['required', 'string', 'max:50'],
            'event' => ['required', 'string', 'max:255'],
            'geos' => ['required', 'string'],
            'traffic' => ['nullable', 'string'],
            'cap' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'in:live,limited,private'],
            'epc_hint' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'is_published' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['in_house'] = $request->boolean('in_house');
        $data['is_published'] = $request->boolean('is_published');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['brand_slug'] = $data['brand_slug'] ?: Str::slug($data['brand']);
        $data['geos'] = array_values(array_filter(array_map('trim', explode(',', $data['geos']))));
        $data['traffic'] = filled($data['traffic'] ?? null)
            ? array_values(array_filter(array_map('trim', explode(',', $data['traffic']))))
            : [];

        return $data;
    }

    protected function uniqueSlug(string $base, ?int $ignoreId = null): string
    {
        $slug = Str::slug($base);
        $original = $slug;
        $i = 1;

        while (
            Offer::query()
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $original.'-'.$i++;
        }

        return $slug;
    }
}
