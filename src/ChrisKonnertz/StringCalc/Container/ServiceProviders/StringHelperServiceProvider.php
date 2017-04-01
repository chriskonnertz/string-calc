<?php

namespace ChrisKonnertz\StringCalc\Container\ServiceProviders;

use ChrisKonnertz\StringCalc\Container\AbstractSingletonServiceProvider;
use ChrisKonnertz\StringCalc\Support\StringHelper;

abstract class StringHelperServiceProvider extends AbstractSingletonServiceProvider
{
    /**
     * @inheritdoc
     */
    protected function createService()
    {
        return new StringHelper();
    }

}