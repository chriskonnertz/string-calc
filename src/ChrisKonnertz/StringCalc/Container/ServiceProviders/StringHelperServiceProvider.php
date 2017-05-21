<?php

namespace ChrisKonnertz\StringCalc\Container\ServiceProviders;

use ChrisKonnertz\StringCalc\Container\AbstractSingletonServiceProvider;
use ChrisKonnertz\StringCalc\Support\StringHelper;

/**
 * This is a service provider class for the string helper class.
 *
 * @package ChrisKonnertz\StringCalc\Container\ServiceProviders
 */
class StringHelperServiceProvider extends AbstractSingletonServiceProvider
{
    /**
     * @inheritdoc
     */
    protected function createService()
    {
        return new StringHelper();
    }

}