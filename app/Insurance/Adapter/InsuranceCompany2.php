<?php
namespace App\Insurance\Adapter;

use App\Insurance\Exception;

/**
 * This is a sample insurance company that named Company2
 *
 * Class InsuranceCompany2
 * @package App\Insurance\Adapter
 */
class InsuranceCompany2 extends AdapterAbstract implements AdapterInterface
{
    /**
     * returns the base price based on defined exceptions
     *
     * @return float
     * @throws \Exception
     */
    public function getBasePrice(): float
    {
        $percent = $this->basePricePercentage;

        if (!empty($this->basePriceException)) {
            if ($this->carValue > $this->basePriceException[0]['borderPrice']) {
                $percent = $this->basePriceException[0]['higherPercentage'];
            } else {
                $percent = $this->basePriceException[0]['lowerPercentage'];
            }
        }

        $this->basePricePercentage = $percent;

        return round($percent / 100 * $this->carValue, 2);
    }

    /**
     * return the total policy calculation
     *
     * @return array
     * @throws \Exception
     */
    public function getPolicyCalculation(): array
    {
        $basePremium = round($this->getBasePrice(), 2);
        $commission  = round($this->commissionPercent / 100 * $basePremium, 2);
        $tax         = round($this->taxPercentage / 100 * $basePremium, 2);

        return [
            'basePremium' => $basePremium,
            'commission'  => $commission,
            'tax'         => $tax,
            'total'       => $basePremium + $commission + $tax,
        ];
    }

    /**
     * returns the array of all installments
     *
     * @return array
     * @throws Exception
     */
    public function getInstallmentsArray(): array
    {
        if (empty($this->installments)) {
            throw new Exception('Invalid installments! Please set the number of installments first');
        }

        $totalPolicy = $this->getPolicyCalculation();

        $installments = [];

        foreach ($totalPolicy as $key => $value) {
            $installments [$key][0] = $value;
            $parts                  = $this->getExactDivisions($value, $this->installments);
            foreach ($parts as $installmentNo => $installmentVal) {
                $installments [$key][$installmentNo] = $installmentVal;
            }
        }

        return $installments;
    }
}