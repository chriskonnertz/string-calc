<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Functions;

use ChrisKonnertz\StringCalc\Exceptions\NumberOfArgumentsException;
use ChrisKonnertz\StringCalc\Symbols\AbstractFunction;

/**
 * PHP pow() function aka eponential expression.
 * Expects two parameters. The first is the base,
 * the second is the exponent.
 * @see http://php.net/manual/en/ref.math.php
 */
class PowFunction extends AbstractFunction
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['pow'];

    /**
     * @inheritdoc
     */
    public function execute(array $arguments)
    {
        if (sizeof($arguments) != 2) {
            throw new NumberOfArgumentsException('Error: Expected two arguments, got '.sizeof($arguments));
        }

        $base = $arguments[0];
        $exponent = $arguments[1];

        return pow($base, $exponent);
    }

}