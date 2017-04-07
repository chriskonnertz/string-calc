<?php

namespace ChrisKonnertz\StringCalc\Container\ServiceProviders;

use ChrisKonnertz\StringCalc\Container\AbstractSingletonServiceProvider;
use ChrisKonnertz\StringCalc\Symbols\SymbolManager;

class SymbolManagerServiceProvider extends AbstractSingletonServiceProvider
{
    /**
     * @inheritdoc
     */
    protected function createService()
    {
        return new SymbolManager();
    }

}