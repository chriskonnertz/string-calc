<?php

namespace ChrisKonnertz\StringCalc\Container;

use ChrisKonnertz\StringCalc\Container\ServiceProviders\InputStreamServiceProvider;
use ChrisKonnertz\StringCalc\Container\ServiceProviders\StringHelperServiceProvider;
use ChrisKonnertz\StringCalc\Container\ServiceProviders\SymbolManagerServiceProvider;

class ServiceProviderRegistry implements ServiceProviderRegistryInterface
{

    /**
     * @inheritdoc
     */
    public function getServiceProviders()
    {
        $serviceProviders = [
            'stringcalc_stringhelper' => StringHelperServiceProvider::class,
            'stringcalc_inputstream' => InputStreamServiceProvider::class,
            'stringcalc_symbolmanager' => SymbolManagerServiceProvider::class,
        ];

        return $serviceProviders;
    }

}