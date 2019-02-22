<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;
use App\Insurance\Factory;

final class InsuranceCalculatorTest extends TestCase
{
    protected static $config;

    protected static $calculator;

    protected function setUp(): void
    {
        self::$config = [
            // base policy price in percent
            'basePricePercent'   => 11,

            // maximum of installments
            'maxInstallments'    => 12,

            // active insurance companies for this app
            'activeCompanies'    => [
                'Company1 (default)',
                'Company2',
            ],

            // supporting multiple rule definition
            'basePriceException' => [
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
            'commissionPercent'  => 17,
        ];

        self::$calculator = Factory::make('company1', self::$config);

    }

    public function testInsuranceAdapterInstance(): void
    {
        $this->assertInstanceOf('\App\Insurance\Adapter\AdapterInterface', self::$calculator);
    }


    public function testTotalPolicyCalculation(): void
    {
        $currentTime  = new DateTime('now');
        $dayOfTheWeek = strtolower($currentTime->format('l'));
        $startTime    = DateTime::createFromFormat('H:i', '15:00');
        $endTime      = DateTime::createFromFormat('H:i', '20:00');


        $policy = self::$calculator->setCarValue(10000)
            ->setInstallments(2)
            ->setTaxPercentage(10)
            ->getPolicyCalculation();

        if ($dayOfTheWeek == 'friday' && ($currentTime >= $startTime && $currentTime <= $endTime)) {
            $this->assertEquals($policy['basePremium'], 1300);
        } else {
            $this->assertEquals($policy['basePremium'], 1100);
        }

        $this->assertEquals($policy['commission'], 187);
        $this->assertEquals($policy['tax'], 110);
        $this->assertEquals($policy['total'], 1397);

        $totalParts = $policy['commission'] + $policy['tax'] + $policy['basePremium'];
        $this->assertEquals($policy['total'], $totalParts);
    }

    public function testEqualInstallmentsCalculation(): void
    {
        $installments = self::$calculator->setCarValue(10000)
            ->setInstallments(2)
            ->setTaxPercentage(10)
            ->getInstallmentsArray();

        $totals = $installments['total'];

        $total = array_shift($totals);

        $this->assertEquals($total, array_sum($totals));
    }

    public function testUnEqualInstallmentsCalculation(): void
    {
        $installments = self::$calculator->setCarValue(10000)
            ->setInstallments(3)
            ->setTaxPercentage(10)
            ->getInstallmentsArray();

        $totals = $installments['total'];

        $total = array_shift($totals);

        $this->assertEquals($total, array_sum($totals));
    }

    public function testThrowingExceptionOnEmptyInstallmentsValue(): void
    {
        $this->expectException(\App\Insurance\Exception::class);

        $calculator = self::$calculator->setCarValue(10000)
            //->setInstallments(3) installments not set
            ->setTaxPercentage(10)
            ->getInstallmentsArray();

    }
}
