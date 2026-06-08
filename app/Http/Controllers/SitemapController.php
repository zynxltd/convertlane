<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $base = rtrim(config('brand.url'), '/');
        $urls = [
            ['loc' => $base, 'priority' => '1.0'],
            ['loc' => "{$base}/advertisers", 'priority' => '0.9'],
            ['loc' => "{$base}/advertisers/enquiry", 'priority' => '0.85'],
            ['loc' => "{$base}/publishers", 'priority' => '0.9'],
            ['loc' => "{$base}/offers", 'priority' => '0.9'],
            ['loc' => "{$base}/apply", 'priority' => '0.9'],
            ['loc' => "{$base}/verticals", 'priority' => '0.8'],
            ['loc' => "{$base}/about", 'priority' => '0.7'],
            ['loc' => "{$base}/contact", 'priority' => '0.7'],
            ['loc' => "{$base}/blog", 'priority' => '0.8'],
        ];

        foreach (config('blog.posts') as $post) {
            $urls[] = [
                'loc' => "{$base}/blog/{$post['slug']}",
                'priority' => '0.6',
                'lastmod' => Carbon::parse($post['published_at'])->toDateString(),
            ];
        }

        $legal = ['privacy', 'terms', 'affiliate-agreement', 'advertiser-agreement'];
        foreach ($legal as $path) {
            $urls[] = [
                'loc' => "{$base}/{$path}",
                'priority' => '0.4',
                'lastmod' => config('legal.last_updated'),
            ];
        }

        return response()
            ->view('sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml');
    }
}
