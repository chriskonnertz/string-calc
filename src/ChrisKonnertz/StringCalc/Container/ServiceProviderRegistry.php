<?php

namespace ChrisKonnertz\StringCalc\Container;

use ChrisKonnertz\StringCalc\Container\ServiceProviders\CalculatorServiceProvider;
use ChrisKonnertz\StringCalc\Container\ServiceProviders\InputStreamServiceProvider;
use ChrisKonnertz\StringCalc\Container\ServiceProviders\StringHelperServiceProvider;
use ChrisKonnertz\StringCalc\Container\ServiceProviders\SymbolContainerServiceProvider;

/**
 * This class is where all service providers are registered
 * (except of those that are registered at runtime).
 *
 * @package ChrisKonnertz\StringCalc\Container
 */
class ServiceProviderRegistry implements ServiceProviderRegistryInterface
{

    /**
     * @inheritdoc
     */
    public function getServiceProviders()
    {
        $serviceProviders = [
            'stringcalc_stringhelper'       => StringHelperServiceProvider::class,
            'stringcalc_inputstream'        => InputStreamServiceProvider::class,
            'stringcalc_symbolcontainer'    => SymbolContainerServiceProvider::class,
            'stringcalc_calculator'         => CalculatorServiceProvider::class,
        ];

        return $serviceProviders;
    }

}