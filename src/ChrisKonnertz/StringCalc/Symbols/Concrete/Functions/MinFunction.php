<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Functions;

use ChrisKonnertz\StringCalc\Exceptions\NumberOfArgumentsException;
use ChrisKonnertz\StringCalc\Symbols\AbstractFunction;

/**
 * PHP min() function. Expects at least one parameter.
 * Example: "min(1,2,3)" => 1, "min(1,-1)" => -1, "min(0,0)" => 0, "min(2)" => 2
 * @see http://php.net/manual/en/ref.math.php
 */
class MinFunction extends AbstractFunction
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['min'];

    /**
     * @inheritdoc
     */
    public function execute(array $arguments)
    {
        if (sizeof($arguments) < 1) {
            throw new NumberOfArgumentsException('Error: Expected at least one argument, none given');
        }

        $min = min($arguments);

        return $min;
    }

}