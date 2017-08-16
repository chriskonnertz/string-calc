<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Functions;

use ChrisKonnertz\StringCalc\Exceptions\NumberOfArgumentsException;
use ChrisKonnertz\StringCalc\Symbols\AbstractFunction;

/**
 * PHP expm1() function aka returns exp(number) - 1,
 * computed in a way that is accurate even when the
 * value of number is close to zero.
 * Expects one parameter.
 *
 * @see http://php.net/manual/en/ref.math.php
 */
class ExpMOneFunction extends AbstractFunction
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['expMOne'];

    /**
     * @inheritdoc
     */
    public function execute(array $arguments)
    {
        if (sizeof($arguments) != 1) {
            throw new NumberOfArgumentsException('Error: Expected one argument, got '.sizeof($arguments));
        }

        $number = $arguments[0];

        return expm1($number);
    }

}