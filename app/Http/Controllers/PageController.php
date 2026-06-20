<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('pages.home');
    }

    public function advertisers(): View
    {
        return view('pages.advertisers');
    }

    public function publishers(): View
    {
        return view('pages.publishers');
    }

    public function verticals(): View
    {
        return view('pages.verticals');
    }

    public function about(): View
    {
        return view('pages.about');
    }

    public function emailSignature(): View
    {
        return view('pages.email-signature');
    }
}
