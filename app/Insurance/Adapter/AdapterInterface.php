<?php

namespace App\Insurance\Adapter;

/**
 * Insurance company adapter interface class
 * All Insurance companies adapter should implement this adapter interface
 *
 *
 * Interface AdapterInterface
 * @package App\Insurance\Adapter
 */
interface AdapterInterface
{
    public function setCarValue(int $value);

    public function setTaxPercentage(float $percentage);

    public function setInstallments(int $count);

    public function getBasePrice();

    public function getPolicyCalculation();

    public function getInstallmentsArray();
}