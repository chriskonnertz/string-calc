<?php

namespace ChrisKonnertz\StringCalc\Container\ServiceProviders;

use ChrisKonnertz\StringCalc\Container\AbstractSingletonServiceProvider;
use ChrisKonnertz\StringCalc\Tokenizer\InputStream;

/**
 * This is a service provider class for the input stream class.
 *
 * @package ChrisKonnertz\StringCalc\Container\ServiceProviders
 */
class InputStreamServiceProvider extends AbstractSingletonServiceProvider
{

    /**
     * @inheritdoc
     */
    protected function createService()
    {
        $stringHelper = $this->getService('stringcalc_stringhelper');

        return new InputStream($stringHelper);
    }

}