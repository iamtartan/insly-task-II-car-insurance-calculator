<?php

/**
 * Car insurance installments calculator
 *
 * Class InsuranceCalculator
 */

class InsuranceCalculator
{
    /**
     * Estimated value of the car (100 - 100 000 EUR)
     * @var integer
     */
    protected $carValue;

    /**
     * Tax percentage
     * @var float
     */
    protected $taxPercentage;

    /**
     * Number of instalments (count of payments in which client wants to pay for the policy (1 – 12))
     * @var int
     */
    protected $installments;

    /**
     *
     * @var float
     */
    protected $basePricePercentage;

    /**
     * base price of policy calculation exception rules
     * @example
     * [
     *      'day'        => 'friday',
     *      'startHour'  => 15,
     *      'endHour'    => 24,
     *      'percentage' => 13
     * ]
     * @var array
     */
    protected $basePriceException;

    /**
     * Commission percent that should added to base price
     * @var
     */
    protected $commissionPercent;


    public function __construct(float $basePricePercentage, float $commissionPercent, array $basePriceException = [])
    {
        $this->basePricePercentage = $basePricePercentage;
        $this->commissionPercent   = $commissionPercent;
        $this->basePriceException  = $basePriceException;
    }

    /**
     * set estimated value of the car
     * @param int $value
     *
     * @return InsuranceCalculator
     */
    public function setCarValue(int $value): self
    {
        $this->carValue = $value;

        return $this;
    }

    /**
     * set the tax percentage for calculation
     * @param float $percentage
     *
     * @return InsuranceCalculator
     */
    public function setTaxPercentage(float $percentage): self
    {
        $this->taxPercentage = $percentage;

        return $this;
    }

    /**
     * Set number of installments
     * @param int $count
     *
     * @return InsuranceCalculator
     */
    public function setInstallments(int $count): self
    {
        $this->installments = $count;

        return $this;
    }

    /**
     * return the total policy calculation
     *
     * @return array
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
     * returns the base price based on defined exceptions
     *
     * @return float
     */
    protected function getBasePrice(): float
    {
        $today = strtolower(date('l'));
        $hour  = date('H');

        $percent = $this->basePricePercentage;

        if (!empty($this->basePriceException)) {
            foreach ($this->basePriceException as $rule) {
                if ($today == $rule['day'] && ($hour >= $rule['startHour'] && $hour <= $rule['endHour'])) {
                    $percent = $rule['percentage'];
                    break;
                }
            }
        }

        $this->basePricePercentage = $percent;

        return round($percent / 100 * $this->carValue, 2);
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
            throw new Exception('Invalid installments! Please set the number of installments first.');
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

    /**
     * returns the exact division for installments based on total value
     *
     * @param float $value
     * @param int $count
     *
     * @return array
     */
    protected function getExactDivisions(float $value, int $count): array
    {
        $eachPart = floatval(bcdiv($value / $count, 1, 2));

        $parts = array_fill(1, $count, $eachPart);

        if (($count * $eachPart) !== $value) {
            $parts [1] = floatval(bcdiv($value - ($eachPart * ($count - 1)), 1, 2));
        }

        return $parts;
    }

    /**
     * returns rendered price matrix
     *
     * @param string $tableId
     * @param string $tableClass
     *
     * @return string
     * @throws Exception
     */
    public function renderInstallmentTable(
        string $tableId = 'insurance_installments_table',
        string $tableClass = 'table-striped'
    ): string {
        $tableHeaders = ['', 'Policy'];
        for ($i = 1; $i <= $this->installments; $i++) {
            $tableHeaders [] = "{$i}";
        }
        $data = $this->getInstallmentsArray();

        $html = '<table id="' . $tableId . '" class="table ' . $tableClass . '">';
        $html .= '<tr><th><th></th><th class="text-center" colspan="'.($this->installments).'">Installments</th></tr>';
        $html .= '<tr><th>' . implode('</th><th>', $tableHeaders) . '</th></tr>';
        $html .= '<tr><td>Car Value</td><td colspan="'.(++$this->installments).'">' . $this->carValue . '</td></tr>';
        $html .= '<tr><td>Base Premium (' . $this->basePricePercentage . '%)</td><td>' . implode('</td><td>',
                $data['basePremium']) . '</td></tr>';
        $html .= '<tr><td>Commission (' . $this->commissionPercent . '%)</td><td>' . implode('</td><td>',
                $data['commission']) . '</td></tr>';
        $html .= '<tr><td>Tax (' . $this->taxPercentage . '%)</td><td>' . implode('</td><td>',
                $data['tax']) . '</td></tr>';
        $html .= '<tr><td><b>Total cost</b></td><td><b>' . implode('</b></td><td><b>',
                $data['total']) . '</b></td></tr>';
        $html .= '</table>';

        return $html;
    }

}