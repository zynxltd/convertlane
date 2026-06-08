<?php

namespace App\Support;

use Illuminate\Support\Facades\URL;

class BrandContact
{
    public const DEFAULT_EMAIL = 'contact@convertlane.co.uk';

    public const DEFAULT_URL = 'https://convertlane.co.uk';

    public static function email(): string
    {
        $raw = env('BRAND_CONTACT_EMAIL')
            ?: env('BRAND_SUPPORT_EMAIL')
            ?: env('BRAND_EMAIL')
            ?: env('LEGAL_PRIVACY_EMAIL')
            ?: env('LEGAL_EMAIL')
            ?: self::DEFAULT_EMAIL;

        return self::normalizeEmail((string) $raw);
    }

    public static function url(): string
    {
        $raw = (string) (env('APP_URL') ?: self::DEFAULT_URL);

        return rtrim(str_replace(
            ['https://convertlane.com', 'http://convertlane.com', 'convertlane.com'],
            ['https://convertlane.co.uk', 'http://convertlane.co.uk', 'convertlane.co.uk'],
            $raw,
        ), '/');
    }

    /**
     * Canonical public site URL for emails, SEO, and external links.
     * Uses APP_PUBLIC_URL when set; otherwise avoids localhost / .test when APP_URL is local.
     */
    public static function publicUrl(): string
    {
        $explicit = config('brand.public_url');
        if (filled($explicit)) {
            return rtrim((string) $explicit, '/');
        }

        $appUrl = (string) (config('app.url') ?: env('APP_URL', ''));
        if (self::isLocalAppUrl($appUrl)) {
            return self::DEFAULT_URL;
        }

        return self::url();
    }

    /**
     * Named route as an absolute URL on the public site (never localhost in mail).
     *
     * @param  array<string, mixed>  $parameters
     */
    public static function route(string $name, array $parameters = []): string
    {
        $root = self::publicUrl();
        $previousRoot = config('app.url');
        $scheme = parse_url($root, PHP_URL_SCHEME) ?: 'https';

        URL::forceRootUrl($root);
        URL::forceScheme($scheme);
        config(['app.url' => $root]);

        try {
            return route($name, $parameters, absolute: true);
        } finally {
            URL::forceRootUrl($previousRoot);
            URL::forceScheme(parse_url((string) $previousRoot, PHP_URL_SCHEME) ?: null);
            config(['app.url' => $previousRoot]);
        }
    }

    public static function isLocalAppUrl(string $url): bool
    {
        if ($url === '') {
            return true;
        }

        $host = strtolower((string) parse_url($url, PHP_URL_HOST));

        if (in_array($host, ['localhost', '127.0.0.1', '::1'], true)) {
            return true;
        }

        return str_ends_with($host, '.test');
    }

    private static function normalizeEmail(string $email): string
    {
        $email = strtolower(trim($email));
        $email = str_replace('@convertlane.com', '@convertlane.co.uk', $email);

        if (in_array($email, [
            'support@convertlane.co.uk',
            'partners@convertlane.co.uk',
            'support@convertlane.com',
            'partners@convertlane.com',
        ], true)) {
            return self::DEFAULT_EMAIL;
        }

        return $email !== '' ? $email : self::DEFAULT_EMAIL;
    }
}
