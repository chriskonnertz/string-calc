<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Functions;

use ChrisKonnertz\StringCalc\Exceptions\NumberOfArgumentsException;
use ChrisKonnertz\StringCalc\Symbols\AbstractFunction;

/**
 * PHP rand() function aka generates a random integer.
 * Expects zero or two parameters. If called with two
 * parameters, the first param is the min and the
 * second param is the max value to be returned.
 *
 * @see http://php.net/manual/en/ref.math.php
 */
class RandFunction extends AbstractFunction
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['rand'];

    /**
     * @inheritdoc
     */
    public function execute(array $arguments)
    {
        if (sizeof($arguments) == 1 or sizeof($arguments) > 2) {
            throw new NumberOfArgumentsException('Error: Expected zero or two arguments, got '.sizeof($arguments));
        }

        if (sizeof($arguments) == 2) {
            $min = $arguments[0];
            $max = $arguments[1];

            return rand($min, $max);
        } else {
            return rand();
        }
    }

}