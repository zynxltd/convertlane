<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class SeoMetaTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array<string, array{0: string, 1?: string}>
     */
    public static function indexablePages(): array
    {
        return [
            'home' => ['/'],
            'about' => ['/about'],
            'advertisers' => ['/advertisers'],
            'advertiser enquiry' => ['/advertisers/enquiry'],
            'publishers' => ['/publishers'],
            'offers' => ['/offers'],
            'verticals' => ['/verticals'],
            'contact' => ['/contact'],
            'apply' => ['/apply'],
            'blog' => ['/blog'],
            'blog article' => ['/blog/cpa-vs-cps-offer-models'],
            'privacy' => ['/privacy'],
            'terms' => ['/terms'],
            'affiliate agreement' => ['/affiliate-agreement'],
            'advertiser agreement' => ['/advertiser-agreement'],
        ];
    }

    #[DataProvider('indexablePages')]
    public function test_indexable_pages_include_core_seo_tags(string $uri): void
    {
        $html = $this->get($uri)->assertOk()->getContent();

        $this->assertMatchesRegularExpression('/<title>[^<]+ConvertLane[^<]*<\/title>/', $html);
        $this->assertStringContainsString('name="description"', $html);
        $this->assertStringContainsString('rel="canonical"', $html);
        $this->assertStringContainsString('property="og:title"', $html);
        $this->assertStringContainsString('property="og:description"', $html);
        $this->assertStringContainsString('property="og:image"', $html);
        $this->assertStringContainsString('name="twitter:image"', $html);
        $this->assertStringContainsString('content="index, follow"', $html);
        $this->assertStringContainsString('application/ld+json', $html);
        $this->assertStringContainsString('<h1', $html);
    }

    /**
     * @return array<string, array{0: string}>
     */
    public static function noindexPages(): array
    {
        return [
            'partner login' => ['/partner/login'],
            'advertiser login' => ['/advertiser/login'],
            'partner password reset' => ['/partner/password/forgot'],
            'advertiser password reset' => ['/advertiser/password/forgot'],
        ];
    }

    #[DataProvider('noindexPages')]
    public function test_private_pages_are_noindex(string $uri): void
    {
        $html = $this->get($uri)->assertOk()->getContent();

        $this->assertStringContainsString('content="noindex, nofollow"', $html);
    }

    public function test_sitemap_lists_public_urls(): void
    {
        $xml = $this->get('/sitemap.xml')->assertOk()->getContent();

        foreach ([
            '/advertisers/enquiry',
            '/blog/cpa-vs-cps-offer-models',
            '/affiliate-agreement',
            '<lastmod>',
        ] as $fragment) {
            $this->assertStringContainsString($fragment, $xml);
        }
    }

    public function test_robots_txt_blocks_private_areas(): void
    {
        $robots = file_get_contents(public_path('robots.txt'));

        $this->assertStringContainsString('Disallow: /admin/', $robots);
        $this->assertStringContainsString('Disallow: /compliance/', $robots);
        $this->assertStringContainsString('convertlane.co.uk/sitemap.xml', $robots);
    }
}
