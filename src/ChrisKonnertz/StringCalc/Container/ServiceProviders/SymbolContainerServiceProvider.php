<?php

namespace ChrisKonnertz\StringCalc\Container\ServiceProviders;

use ChrisKonnertz\StringCalc\Container\AbstractSingletonServiceProvider;
use ChrisKonnertz\StringCalc\Symbols\SymbolContainer;

class SymbolContainerServiceProvider extends AbstractSingletonServiceProvider
{
    /**
     * @inheritdoc
     */
    protected function createService()
    {
        return new SymbolContainer();
    }

}