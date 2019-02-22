<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;
use App\Model\InsuranceCalculator;

final class InsuranceCalculatorTest extends TestCase
{
    protected $calculator;

    public function __construct()
    {
        parent::__construct();
        $this->calculator = new InsuranceCalculator(
            11,
            17,
            [
                [
                    'day'        => 'friday',
                    'startHour'  => '15:00',
                    'endHour'    => '20:00',
                    'percentage' => '13',
                ],
            ]
        );
    }

    public function testTotalPolicyCalculation(): void
    {
        $currentTime  = new DateTime('now');
        $dayOfTheWeek = strtolower($currentTime->format('l'));
        $startTime    = DateTime::createFromFormat('H:i', '15:00');
        $endTime      = DateTime::createFromFormat('H:i', '20:00');


        $policy = $this->calculator->setCarValue(10000)
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
        $installments = $this->calculator->setCarValue(10000)
            ->setInstallments(2)
            ->setTaxPercentage(10)
            ->getInstallmentsArray();

        $totals = $installments['total'];

        $total = array_shift($totals);

        $this->assertEquals($total, array_sum($totals));
    }

    public function testUnEqualInstallmentsCalculation(): void
    {
        $installments = $this->calculator->setCarValue(10000)
            ->setInstallments(3)
            ->setTaxPercentage(10)
            ->getInstallmentsArray();

        $totals = $installments['total'];

        $total = array_shift($totals);

        $this->assertEquals($total, array_sum($totals));
    }

    public function testThrowingExceptionOnEmptyInstallmentsValue(): void
    {
        $this->expectException(Exception::class);

        $calculator = $this->calculator->setCarValue(10000)
            //->setInstallments(3) installments not set
            ->setTaxPercentage(10)
            ->getInstallmentsArray();

    }
}
