<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Functions;

use ChrisKonnertz\StringCalc\Exceptions\NumberOfArgumentsException;
use ChrisKonnertz\StringCalc\Symbols\AbstractFunction;

/**
 * PHP round() function aka rounds a float.
 * Expects one or two parameters. The first
 * parameter is the value to round, the second
 * is the number of decimal digits to round to.
 * It defaults to 0.
 * @see http://php.net/manual/en/ref.math.php
 */
class RoundFunction extends AbstractFunction
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['round'];

    /**
     * @inheritdoc
     */
    public function execute(array $arguments)
    {
        if (sizeof($arguments) == 0 or sizeof($arguments) > 2) {
            throw new NumberOfArgumentsException('Error: Expected one or two arguments, got '.sizeof($arguments));
        }

        $number = $arguments[0];

        $precision = 0;
        if (sizeof($arguments) > 1) {
            $precision = $arguments[1];
        }

        return round($number, $precision);
    }

}