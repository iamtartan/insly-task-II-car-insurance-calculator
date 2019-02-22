# insly-task-II-car-insurance-calculator

## ![important](https://cdn2.iconfinder.com/data/icons/tango/32x32/status/software-update-urgent.png) Please check **modern** branch code too

### Screenshot

![Screenshot](/screenshot.png?raw=true "Screenshot")

### Installing


#### run **basic** branch

For running **basic** branch just copy **config-sample.php** file to **config.php** and goto index.php file in /public folder.

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

#### run **modern** branch

1. For running **modern** branch just copy **config-sample.php** file to **config.php**

```php
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

    // supporting multiple rule definition for multiple insurance companies
    'basePriceException'   => [
        // company1: the company that defined in assignment
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
                'borderPrice'      => 25000, // in euro
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
```

2. run php built in webserver

```bash
$ cd /your/path/to/project/public 
$ php -S localhost:8000 
```

### Predefined Rules

- If the amount is **not divisible** by installments, the **First installment** values will be different from other installments.
- Base price of policy is **11%** from entered car value, except every Friday 15:00-20:: o’clock (user time) when it is **13%**. More rules can be add in project config file.
- I've added **1 second delay** to response time just for better experience in ajax calls in **demo**.

### Branch details

- The project developed with **vanilla** PHP and Javascript without using any framework, template engine or third-party package.
- This project has been developed in two branches **basic** and **modern**.
- I haven't used php **composer**, **DI** or any other modern concepts in **basic** branch.
- Modern concepts and structures are used just in **modern** branch.
- In branch **modern** multi insurance company implemented. the assigment insurance rules defined as **Company1**. 
- **Unit tests** just added in **modern** branch. and you can run by the following command

```bash
$ composer install
$ ./vendor/bin/phpunit
```
