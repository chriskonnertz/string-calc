<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Functions;

use ChrisKonnertz\StringCalc\Exceptions\NumberOfArgumentsException;
use ChrisKonnertz\StringCalc\Symbols\AbstractFunction;

/**
 * PHP max() function. Expects at least one parameter.
 * Example: "max(1,2,3)" => 3, "max(1,-1)" => 1, "max(0,0)" => 0, "max(2)" => 2
 * @see http://php.net/manual/en/ref.math.php
 */
class MaxFunction extends AbstractFunction
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['max'];

    /**
     * @inheritdoc
     */
    public function execute(array $arguments)
    {
        if (sizeof($arguments) < 1) {
            throw new NumberOfArgumentsException('Error: Expected at least one argument, none given');
        }

        $max = max($arguments);

        return $max;
    }

}