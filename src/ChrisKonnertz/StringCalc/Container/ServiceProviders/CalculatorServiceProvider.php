<?php

namespace ChrisKonnertz\StringCalc\Container\ServiceProviders;

use ChrisKonnertz\StringCalc\Calculator\Calculator;
use ChrisKonnertz\StringCalc\Container\AbstractSingletonServiceProvider;

/**
 * This is a service provider class for the calculator class.
 *
 * @package ChrisKonnertz\StringCalc\Container\ServiceProviders
 */
class CalculatorServiceProvider extends AbstractSingletonServiceProvider
{
    /**
     * @inheritdoc
     */
    protected function createService()
    {
        return new Calculator();
    }

}