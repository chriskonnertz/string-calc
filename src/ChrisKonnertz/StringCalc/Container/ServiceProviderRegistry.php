<?php

namespace ChrisKonnertz\StringCalc\Container;

use ChrisKonnertz\StringCalc\Container\ServiceProviders\InputStreamServiceProvider;
use ChrisKonnertz\StringCalc\Container\ServiceProviders\StringHelperServiceProvider;

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
        ];

        return $serviceProviders;
    }

}