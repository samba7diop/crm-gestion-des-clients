<?php

return [
    'lead_scoring' => [
        'source' => [
            'website' => 10,
            'referral' => 25,
            'email' => 5,
            'campagne' => 15,
            'salon' => 20,
            'autre' => 5,
        ],
        'secteur' => [
            'industrie' => 15,
            'services' => 10,
            'retail' => 10,
            'sante' => 20,
            'tech' => 25,
            'autre' => 5,
        ],
        'entreprise_size' => [
            'petite' => 5,
            'moyenne' => 10,
            'grande' => 20,
            'autre' => 5,
        ],
    ],
    'opportunity_types' => [
        'standard' => 'Standard',
        'renewal' => 'Renouvellement',
        'upsell' => 'Upsell',
        'cross_sell' => 'Cross-sell',
    ],
    'default_stages' => [
        'prospection',
        'qualification',
        'proposition',
        'negociation',
        'gagne',
        'perdu',
    ],
];
