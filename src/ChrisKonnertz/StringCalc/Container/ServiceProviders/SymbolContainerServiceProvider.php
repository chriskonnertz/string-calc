<?php

namespace ChrisKonnertz\StringCalc\Container\ServiceProviders;

use ChrisKonnertz\StringCalc\Container\AbstractSingletonServiceProvider;
use ChrisKonnertz\StringCalc\Symbols\SymbolContainer;

/**
 * This is a service provider class for the symbol container class.
 *
 * @package ChrisKonnertz\StringCalc\Container\ServiceProviders
 */
class SymbolContainerServiceProvider extends AbstractSingletonServiceProvider
{
    
    /**
     * @inheritdoc
     */
    protected function createService()
    {
        $stringHelper = $this->getService('stringcalc_stringhelper');

        return new SymbolContainer($stringHelper);
    }

}
