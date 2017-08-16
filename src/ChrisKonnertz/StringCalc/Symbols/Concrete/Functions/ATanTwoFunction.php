<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Functions;

use ChrisKonnertz\StringCalc\Exceptions\NumberOfArgumentsException;
use ChrisKonnertz\StringCalc\Symbols\AbstractFunction;

/**
 * PHP atan2() function aka arc tangent of two variables.
 * Expects two parameters. The first is the dividend param,
 * the second is the divisor param.
 * @see http://php.net/manual/en/ref.math.php
 */
class ATanTwoFunction extends AbstractFunction
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['aTanTwo'];

    /**
     * @inheritdoc
     */
    public function execute(array $arguments)
    {
        if (sizeof($arguments) != 2) {
            throw new NumberOfArgumentsException('Error: Expected two arguments, got '.sizeof($arguments));
        }

        $firstNumber = $arguments[0];
        $secondNumber = $arguments[1];

        return atan2($firstNumber, $secondNumber);
    }

}