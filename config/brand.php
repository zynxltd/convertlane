<?php

use App\Support\BrandContact;

return [
    'name' => 'ConvertLane',
    'logo' => '/images/convertlane-logo.png',
    'legal_name' => 'ConvertLane Ltd',
    'tagline' => 'Scale What Converts',
    'descriptor' => 'Performance affiliate network',
    'signature' => 'Vetted partners. Clear IOs. Payouts on schedule.',
    'origin' => 'We review every partner before they get tracking links — no open sign-up wall, no mystery traffic. Advertisers get quality conversions; publishers get net-30 payouts reconciled to approved stats.',
    'description' => 'ConvertLane is a performance affiliate network connecting premium advertisers with vetted publishers. CPA, CPL, CPS, and hybrid deals across finance, iGaming, health, SaaS, and e-commerce.',

    'identity' => [
        'pillars' => [
            [
                'title' => 'Reviewed before they track',
                'description' => 'KYB/KYC, traffic proof, and sanctions checks on every application. No auto-approvals — incomplete files are closed after seven days.',
                'icon' => 'lane',
            ],
            [
                'title' => 'Offers set up by your AM',
                'description' => 'Caps, postbacks, and creatives configured from your signed IO — not a self-serve panel where settings drift out of sync with what you agreed.',
                'icon' => 'chart',
            ],
            [
                'title' => 'Payouts matched to approved stats',
                'description' => 'Net-30 on the 15th for the prior month. Finance reconciles each run against approved conversions — chargebacks and invalid events are deducted, not buried.',
                'icon' => 'shield',
            ],
        ],
    ],

    'trust_highlights' => [
        [
            'label' => 'UK registered',
            'detail' => 'England & Wales',
            'icon' => 'building',
        ],
        [
            'label' => 'Every partner',
            'detail' => 'Manually vetted',
            'icon' => 'check',
        ],
        [
            'label' => 'Reporting',
            'detail' => 'Performance stats',
            'icon' => 'chart',
        ],
    ],

    'trust_badges' => [
        ['name' => 'GDPR aware', 'icon' => 'shield'],
        ['name' => 'Conversion tracking', 'icon' => 'chart'],
        ['name' => 'Net-30 payouts', 'icon' => 'wallet'],
        ['name' => 'Account Managers', 'icon' => 'support'],
        ['name' => 'Fraud review', 'icon' => 'lock'],
    ],

    'url' => BrandContact::url(),
    'public_url' => env('APP_PUBLIC_URL'),
    'contact_email' => BrandContact::email(),
    'email' => BrandContact::email(),
    'support_email' => BrandContact::email(),
    'phone' => env('BRAND_PHONE', '+44 20 1234 5678'),
    'address' => 'ConvertLane Ltd, United Kingdom',
    'partner_panel_url' => env('PARTNER_PANEL_URL', 'https://convertlane.offer18.com'),
    'advertiser_panel_url' => env('ADVERTISER_PANEL_URL', 'https://convertlane.offer18.com/m'),
    'hero_background' => env('BRAND_HERO_BACKGROUND', '/images/hero/performance-analytics.jpg'),
    'hero_use_video' => env('BRAND_HERO_USE_VIDEO', true),
    'section_parallax_image' => env('BRAND_SECTION_PARALLAX_IMAGE', '/images/hero/performance-analytics.jpg'),
    'social' => [
        'linkedin' => 'https://linkedin.com/company/convertlane',
        'twitter' => 'https://x.com/convertlane',
    ],
    'hero_video' => env('BRAND_HERO_VIDEO', '/videos/hero-bg-1.mp4'),
    'hero_video_poster' => env('BRAND_HERO_VIDEO_POSTER', '/images/hero/performance-analytics.jpg'),
    'hero_videos' => [
        '/videos/hero-bg-1.mp4',
        '/videos/hero-bg-2.mp4',
        '/videos/hero-bg-3.mp4',
        '/videos/hero-bg-4.mp4',
    ],
    'hero_rotate_interval' => (int) env('BRAND_HERO_ROTATE_INTERVAL', 5000),

    'hero_items' => [
        [
            'word' => 'What Converts',
            'verb' => 'Scale',
            'eyebrow' => 'Performance affiliate network',
            'tagline' => 'CPA, CPL, and CPS programmes with manually vetted partners',
        ],
        [
            'word' => 'Publisher Revenue',
            'verb' => 'Grow',
            'eyebrow' => 'For publishers',
            'tagline' => 'Dedicated account managers, approved offers, and net-30 payouts',
        ],
        [
            'word' => 'Quality Conversions',
            'verb' => 'Drive',
            'eyebrow' => 'For advertisers',
            'tagline' => 'Reviewed traffic partners — no open sign-up wall',
        ],
        [
            'word' => 'Live Programmes',
            'verb' => 'Launch',
            'eyebrow' => 'Offers & verticals',
            'tagline' => 'Finance, iGaming, health, SaaS, e-commerce, and more',
        ],
    ],

    'hero_dashboard' => [
        'stats' => [
            ['label' => 'Clicks', 'value' => '842K', 'delta' => '+12.4%'],
            ['label' => 'Conv. rate', 'value' => '4.8%', 'delta' => '+0.6%'],
            ['label' => 'EPC', 'value' => '£2.14', 'delta' => '+8.2%'],
        ],
        'bars' => [35, 55, 40, 70, 50, 80, 60, 90, 55, 75, 65, 85],
    ],

    'stats' => [
        ['value' => '6', 'label' => 'Core verticals'],
        ['value' => '100+', 'label' => 'Offers'],
        ['value' => 'Net-30', 'label' => 'Payouts'],
    ],
    'verticals' => [
        ['slug' => 'finance', 'name' => 'Finance & Fintech', 'icon' => 'banknotes', 'description' => 'Loans, cards, trading, crypto, and banking with strict compliance workflows.'],
        ['slug' => 'igaming', 'name' => 'iGaming & Betting', 'icon' => 'dice', 'description' => 'Licensed operators with geo-targeted creatives and real-time conversion caps.'],
        ['slug' => 'health', 'name' => 'Health & Wellness', 'icon' => 'heart', 'description' => 'Nutraceuticals, telehealth, and fitness subscriptions with pre-lander approval.'],
        ['slug' => 'saas', 'name' => 'SaaS & B2B', 'icon' => 'cloud', 'description' => 'Trial-to-paid funnels, demo requests, and enterprise lead gen with LTV modelling.'],
        ['slug' => 'ecommerce', 'name' => 'E-Commerce & DTC', 'icon' => 'shopping-bag', 'description' => 'CPS and hybrid CPA+CPS programmes with coupon and content policies.'],
        ['slug' => 'dating', 'name' => 'Dating & Social', 'icon' => 'users', 'description' => 'SOI/DOI flows with fraud screening and carrier billing where applicable.'],
    ],

    'registered' => 'England & Wales',

    'vertical_images' => [
        'finance' => '/images/verticals/finance.jpg',
        'igaming' => '/images/verticals/igaming.jpg',
        'health' => '/images/verticals/health.jpg',
        'saas' => '/images/verticals/saas.jpg',
        'ecommerce' => '/images/verticals/ecommerce.jpg',
        'dating' => '/images/verticals/dating.jpg',
    ],

    'testimonials' => [],

    'show_team' => env('BRAND_SHOW_TEAM', false),

    'leadership' => [
        [
            'name' => 'Tom Jameson',
            'title' => 'Director',
            'bio' => '10+ years in the affiliate industry. Leads network strategy, partner standards, and commercial direction across all verticals.',
            'photo' => '/images/team/tom-jameson.png',
            'linkedin' => '#',
        ],
        [
            'name' => 'Marcus Webb',
            'title' => 'Head of Compliance',
            'bio' => 'Former fintech MLRO. Leads KYC/KYB, sanctions screening, and due diligence on every partner application.',
            'photo' => '/images/team/marcus-webb.jpg',
            'linkedin' => '#',
        ],
        [
            'name' => 'James Okonkwo',
            'title' => 'Director of Publisher Partnerships',
            'bio' => 'Managed £40M+ annual affiliate spend across EU iGaming and SaaS. Recruits and manages top publisher relationships.',
            'photo' => '/images/team/james-okonkwo.jpg',
            'linkedin' => '#',
        ],
        [
            'name' => 'Elena Rodriguez',
            'title' => 'Director of Advertiser Sales',
            'bio' => 'Specialises in health and DTC. Structures IOs and offer launches that align advertiser LTV with publisher incentives.',
            'photo' => '/images/team/elena-rodriguez.jpg',
            'linkedin' => '#',
        ],
    ],

    'sections' => [
        'compliance' => '/images/sections/compliance-review.jpg',
        'meeting' => '/images/sections/partner-meeting.jpg',
        'office' => '/images/sections/office.jpg',
    ],

    'page_images' => [
        'home' => 'compliance',
        'about' => 'office',
        'publishers' => 'meeting',
        'advertisers' => null,
        'verticals' => 'vertical_images',
        'offers' => null,
        'contact' => null,
        'apply' => null,
    ],
];
