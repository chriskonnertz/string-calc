<?php

namespace ChrisKonnertz\StringCalc\Container\ServiceProviders;

use ChrisKonnertz\StringCalc\Container\AbstractSingletonServiceProvider;
use ChrisKonnertz\StringCalc\Tokenizer\InputStream;

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