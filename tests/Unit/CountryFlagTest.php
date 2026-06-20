<?php

namespace Tests\Unit;

use App\Support\CountryFlag;
use PHPUnit\Framework\TestCase;

class CountryFlagTest extends TestCase
{
    public function test_normalizes_common_aliases(): void
    {
        $this->assertSame('GB', CountryFlag::normalize('UK'));
        $this->assertSame('US', CountryFlag::normalize('USA'));
        $this->assertSame('US', CountryFlag::normalize('us'));
    }

    public function test_builds_roundel_url_for_iso_codes(): void
    {
        $this->assertSame(
            'https://hatscripts.github.io/circle-flags/flags/us.svg',
            CountryFlag::roundelUrl('US')
        );
    }

    public function test_returns_null_for_invalid_geo(): void
    {
        $this->assertNull(CountryFlag::normalize('—'));
        $this->assertNull(CountryFlag::roundelUrl('—'));
    }
}
