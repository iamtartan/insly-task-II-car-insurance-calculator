<?php
return [
    // base policy price in percent
    'basePricePercent'   => 11,

    // maximum of installments
    'maxInstallments' => 12,

    // supporting multiple rule definition
    'basePriceException' => [
        // exception rule number 1
        [
            'day'       => 'friday',
            'startHour' => 15,
            'endHour'   => 24,
            'percentage'   => 13
        ]
    ],

    // our commission in percent
    'commissionPercent'  => 17,
];