# insly-task-II-car-insurance-calculator

### Screenshot

![Screenshot](/screenshot.png?raw=true "Screenshot")

### Installing

For running <b>basic (master)</b> branch just copy <b>config-sample.php</b> file to <b>config.php</b> and run index.php file in public folder.

```php
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
            'startHour' => '15:00',
            'endHour'   => '24:00',
            'percentage'   => 13
        ]
    ],

    // our commission in percent
    'commissionPercent'  => 17,
];

```

### Rules

- If the amount is <b>not divisible</b> by installments, the <b>first installment</b> values will be different from other installments.
- Base price of policy is <b>11%</b> from entered car value, except every Friday 15-20 o’clock (user time) when it is <b>13%</b>. More rules can be added in config file.
- I've added <b>1 second delay</b> to response time just for better experience in <b>demo</b>.

### Branch details

- The project developed with <b>vanilla</b> PHP and Javascript without using any framework, template engine or third-party package.
- This project has been developed in two branches <b>basic (master)</b> and <b>modern</b>.
- I haven't used php <b>composer</b>, <b>DI</b> or any other modern concepts in <b>basic</b> branch.
- Modern concepts and structures are used just in the <b>modern</b> branch.
- Basic branch does not contain <b>phpunit</b> test.
