<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete;

use ChrisKonnertz\StringCalc\Symbols\AbstractFunction;

/**
 * PHP max() function. Expects at least one parameter.
 * Example: "max(1,2,3)" => 3, "max(1,-1)" => 1, "max(0,0)" => 0, "max(2)" => 2
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
            throw new \InvalidArgumentException('Error: Expected at least one argument, none given.');
        }

        $max = max($arguments);

        return $max;
    }

}