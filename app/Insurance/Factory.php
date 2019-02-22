<?php

namespace App\Insurance;

use App\Insurance\Adapter\AdapterInterface;
use App\Insurance\Exception;

class Factory
{
    /**
     * @var AdapterInterface
     */
    protected static $insuranceAdapter;

    /**
     * @param string $adapter
     * @param array $config
     *
     * @return AdapterInterface
     * @throws Exception
     */
    public static function make(string $adapter, array $config): AdapterInterface
    {
        $adapterClass = 'Insurance'.ucfirst(strtolower($adapter));

        $adapterNamespace = 'App\Insurance\Adapter\\';
        $adapterName      = $adapterNamespace . $adapterClass;

        if (!class_exists($adapterName)) {
            throw new Exception("Adapter class '$adapterName' does not exists!");
        }

        self::$insuranceAdapter = new $adapterName(
            $config['basePricePercent'],
            $config['commissionPercent'],
            $config['basePriceException'][$adapter]
        );

        if (!self::$insuranceAdapter instanceof AdapterInterface) {
            throw new Exception('Insurance company adapter should implement adapter interface class');
        }

        return self::$insuranceAdapter;
    }
}
