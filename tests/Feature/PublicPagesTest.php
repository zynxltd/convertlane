<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array<string, array{0: string}>
     */
    public static function publicGetRoutes(): array
    {
        return [
            'home' => ['/'],
            'about' => ['/about'],
            'advertisers' => ['/advertisers'],
            'publishers' => ['/publishers'],
            'offers' => ['/offers'],
            'verticals' => ['/verticals'],
            'contact' => ['/contact'],
            'partner login' => ['/partner/login'],
            'advertiser login' => ['/advertiser/login'],
            'advertiser enquiry' => ['/advertisers/enquiry'],
            'apply' => ['/apply'],
            'blog' => ['/blog'],
            'blog cpa vs cps' => ['/blog/cpa-vs-cps-offer-models'],
            'blog in-house vs network' => ['/blog/affiliate-network-vs-in-house-program'],
            'blog compliance' => ['/blog/affiliate-compliance-checklist-2026'],
            'privacy' => ['/privacy'],
            'terms' => ['/terms'],
            'affiliate agreement' => ['/affiliate-agreement'],
            'advertiser agreement' => ['/advertiser-agreement'],
            'sitemap' => ['/sitemap.xml'],
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('publicGetRoutes')]
    public function test_public_pages_return_successful_response(string $uri): void
    {
        $this->get($uri)->assertOk();
    }
}
