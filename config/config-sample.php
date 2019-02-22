<?php
return [
    // base policy price in percent
    'basePricePercent'     => 11,

    // maximum of installments
    'maxInstallments'      => 12,

    // active insurance companies for this app
    'activeCompanies' => [
        'company1' => 'Company1 (default company)',
        'company2' => 'Company2'
    ],

    // supporting multiple rule definition
    'basePriceException'   => [
        'company1' => [
            // exception rule number 1
            [
                'day'        => 'friday',
                'startHour'  => '15:00',
                'endHour'    => '20:00',
                'percentage' => 13,
            ],
        ],

        'company2' => [
            // exception rule number 1
            [
                'borderPrice'      => 25000, // in dollar
                'lowerPercentage'  => 12,
                'higherPercentage' => 14,
            ],
        ],

        'company3' => [
            // exception rule number 1
            [
                'days'              => 'friday,saturday,sunday',
                'defaultPercentage' => 11,
                'percentage'        => 13,
            ],
        ],
    ],

    // our commission in percent
    'commissionPercent'    => 17,
];