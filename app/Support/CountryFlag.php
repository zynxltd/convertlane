<?php

namespace App\Support;

class CountryFlag
{
    /**
     * @var array<string, string>
     */
    protected static array $aliases = [
        'UK' => 'GB',
        'USA' => 'US',
    ];

    public static function normalize(string $geo): ?string
    {
        $code = strtoupper(trim($geo));

        if ($code === '' || in_array($code, ['—', '-', 'N/A', 'NA'], true)) {
            return null;
        }

        $code = self::$aliases[$code] ?? $code;

        if (! preg_match('/^[A-Z]{2}$/', $code)) {
            return null;
        }

        return $code;
    }

    public static function name(string $geo): string
    {
        $code = self::normalize($geo);

        if ($code === null) {
            return trim($geo) !== '' ? trim($geo) : 'Unknown';
        }

        return config('countries.'.$code, $code);
    }

    public static function roundelUrl(string $geo): ?string
    {
        $code = self::normalize($geo);

        if ($code === null) {
            return null;
        }

        return 'https://hatscripts.github.io/circle-flags/flags/'.strtolower($code).'.svg';
    }
}
