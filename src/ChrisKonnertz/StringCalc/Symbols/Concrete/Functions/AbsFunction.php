<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Functions;

use ChrisKonnertz\StringCalc\Symbols\AbstractFunction;

/**
 * PHP abs() function. Expects one parameter.
 * Example: "abs(2)" => 2, "abs(-2)" => 2, "abs(0)" => 0
 */
class AbsFunction extends AbstractFunction
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['abs'];

    /**
     * @inheritdoc
     */
    public function execute(array $arguments)
    {
        if (sizeof($arguments) != 1) {
            throw new \InvalidArgumentException('Error: Expected one argument, got '.sizeof($arguments));
        }

        $number = $arguments[0];

        return abs($number);
    }

}