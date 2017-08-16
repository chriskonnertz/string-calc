<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Functions;

use ChrisKonnertz\StringCalc\Exceptions\NumberOfArgumentsException;
use ChrisKonnertz\StringCalc\Symbols\AbstractFunction;

/**
 * PHP log1p() function aka returns log(1 + number),
 * computed in a way that is accurate even when
 * the value of number is close to zero.
 * Expects one parameter.
 *
 * @see http://php.net/manual/en/ref.math.php
 */
class LogOnePFunction extends AbstractFunction
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['logOneP'];

    /**
     * @inheritdoc
     */
    public function execute(array $arguments)
    {
        if (sizeof($arguments) != 1) {
            throw new NumberOfArgumentsException('Error: Expected one argument, got '.sizeof($arguments));
        }

        $number = $arguments[0];

        return log1p($number);
    }

}