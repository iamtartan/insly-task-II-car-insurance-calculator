# insly-task-II-car-insurance-calculator

### Screenshot

![Screenshot](/screenshot.png?raw=true "Screenshot")

### Installing

For running **basic** branch just copy **config-sample.php** file to **config.php** and goto index.php file in /public folder.

For running **modern** branch you can user php built in web server and goto / folder.

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
run project in **modern** branch

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
- **Unit tests** just added in **modern** branch. and you can sun by the following command

```bash
$ composer install
$ ./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/InsuranceCalculatorTest
```
