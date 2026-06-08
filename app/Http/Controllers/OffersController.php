<?php

namespace App\Http\Controllers;

use App\Services\OfferCatalog;
use Illuminate\View\View;

class OffersController extends Controller
{
    public function __construct(
        protected OfferCatalog $catalog,
    ) {}

    public function index(): View
    {
        return view('pages.offers', [
            'offers' => $this->catalog->live(),
            'inHouseBrands' => $this->catalog->inHouseBrands(),
            'filters' => $this->catalog->filterOptions(),
            'counts' => $this->catalog->counts(),
        ]);
    }
}
