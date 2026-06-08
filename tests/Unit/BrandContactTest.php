<?php

namespace Tests\Unit;

use App\Support\BrandContact;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class BrandContactTest extends TestCase
{
    #[DataProvider('legacyEmails')]
    public function test_legacy_addresses_normalize_to_contact_co_uk(string $legacy): void
    {
        $method = new \ReflectionMethod(BrandContact::class, 'normalizeEmail');
        $method->setAccessible(true);

        $this->assertSame(BrandContact::DEFAULT_EMAIL, $method->invoke(null, $legacy));
    }

    public function test_public_url_uses_production_domain_when_app_url_is_local(): void
    {
        config([
            'app.url' => 'http://localhost',
            'brand.public_url' => null,
        ]);

        $this->assertSame('https://convertlane.co.uk', BrandContact::publicUrl());
    }

    public function test_public_url_honours_app_public_url_override(): void
    {
        config([
            'app.url' => 'http://localhost',
            'brand.public_url' => 'https://convertlane.co.uk',
        ]);

        $this->assertSame('https://convertlane.co.uk', BrandContact::publicUrl());
    }

    public function test_route_uses_public_url_not_localhost(): void
    {
        config([
            'app.url' => 'http://localhost',
            'brand.public_url' => 'https://convertlane.co.uk',
        ]);

        $this->assertSame(
            'https://convertlane.co.uk/partner/login',
            BrandContact::route('partner.login'),
        );
    }

    public static function legacyEmails(): array
    {
        return [
            ['partners@convertlane.com'],
            ['support@convertlane.com'],
            ['partners@convertlane.co.uk'],
            ['support@convertlane.co.uk'],
        ];
    }
}
