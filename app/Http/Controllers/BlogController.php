<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        return view('pages.blog.index', [
            'posts' => config('blog.posts'),
        ]);
    }

    public function show(string $slug): View|Response
    {
        $post = collect(config('blog.posts'))->firstWhere('slug', $slug);

        if (! $post) {
            abort(404);
        }

        return view('pages.blog.show', compact('post'));
    }
}
