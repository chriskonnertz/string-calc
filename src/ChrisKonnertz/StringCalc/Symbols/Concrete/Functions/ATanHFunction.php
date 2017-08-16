<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Functions;

use ChrisKonnertz\StringCalc\Exceptions\NumberOfArgumentsException;
use ChrisKonnertz\StringCalc\Symbols\AbstractFunction;

/**
 * PHP atanh() function aka inverse hyperbolic tangent. Expects one parameter.
 * @see http://php.net/manual/en/ref.math.php
 */
class ATanHFunction extends AbstractFunction
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['aTanH'];

    /**
     * @inheritdoc
     */
    public function execute(array $arguments)
    {
        if (sizeof($arguments) != 1) {
            throw new NumberOfArgumentsException('Error: Expected one argument, got '.sizeof($arguments));
        }

        $number = $arguments[0];

        return atanh($number);
    }

}