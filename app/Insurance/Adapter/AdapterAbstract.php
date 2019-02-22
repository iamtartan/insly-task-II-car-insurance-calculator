<?php

namespace App\Insurance\Adapter;

/**
 * Abstract class for all insurance companies
 *
 * Interface AdapterAbstract
 * @package App\Insurance\Adapter
 */
abstract class AdapterAbstract
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
     *      'startHour'  => '15:00',
     *      'endHour'    => '24:00',
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
     * @return AdapterAbstract
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
     * @return AdapterAbstract
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
     * @return AdapterAbstract
     */
    public function setInstallments(int $count): self
    {
        $this->installments = $count;

        return $this;
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
     * @throws \App\Insurance\Exception
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