<?php

return [
    'statuses' => [
        'applied',
        'documents_requested',
        'under_review',
        'enhanced_dd',
        'on_hold',
        'approved',
        'rejected',
        'offboarded',
    ],

    'risk_bands' => [
        'low' => ['min' => 0, 'max' => 19],
        'medium' => ['min' => 20, 'max' => 39],
        'high' => ['min' => 40, 'max' => 59],
        'critical' => ['min' => 60, 'max' => 999],
    ],

    'reject_codes' => [
        'publisher' => [
            'R-01' => 'Entity / registration insufficient',
            'R-02' => 'Traffic proof or quality failed',
            'R-03' => 'Sanctions / PEP concern',
            'R-04' => 'Fraud / forgery / blocklist',
            'R-05' => 'Payout / financial mismatch',
            'R-06' => 'Documents incomplete or deadline missed',
            'R-07' => 'Other — see internal notes',
        ],
        'advertiser' => [
            'A-01' => 'Financial / credit / prepay failed',
            'A-02' => 'Licence or regulatory failure',
            'A-03' => 'Product / landing non-compliant',
            'A-04' => 'Sanctions / PEP concern',
            'A-05' => 'Technical / tracking failed',
            'A-06' => 'Entity / signatory issue',
            'A-07' => 'Other — see internal notes',
        ],
    ],

    'document_sla_days' => 7,
    'review_sla_days' => 5,

    'internal_access_key' => env('COMPLIANCE_ACCESS_KEY'),
];
