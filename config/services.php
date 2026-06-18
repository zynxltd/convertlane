<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'affise' => [
        'url' => env('AFFISE_API_URL', 'https://api.affise.com'),
        'key' => env('AFFISE_API_KEY'),
    ],

    'offer18' => [
        'api_base' => env('OFFER18_API_BASE', 'https://api.offer18.com'),
        'mid' => env('OFFER18_MID'),
        'api_key' => env('OFFER18_API_KEY'),
        'secret_key' => env('OFFER18_SECRET_KEY'),
        'partner_fallback_url' => env('PARTNER_PANEL_URL', 'https://convertlane.offer18.com'),
        'advertiser_fallback_url' => env('ADVERTISER_PANEL_URL', 'https://convertlane.offer18.com/m'),
    ],

    'turnstile' => [
        'site_key' => env('TURNSTILE_SITE_KEY'),
        'secret_key' => env('TURNSTILE_SECRET_KEY'),
    ],

];
