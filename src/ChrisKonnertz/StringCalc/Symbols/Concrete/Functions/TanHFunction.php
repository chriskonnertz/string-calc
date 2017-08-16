<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Functions;

use ChrisKonnertz\StringCalc\Exceptions\NumberOfArgumentsException;
use ChrisKonnertz\StringCalc\Symbols\AbstractFunction;

/**
 * PHP tanh() function aka hyperbolic tangent.
 * Expects one parameter.
 * @see http://php.net/manual/en/ref.math.php
 */
class TanHFunction extends AbstractFunction
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['tanh'];

    /**
     * @inheritdoc
     */
    public function execute(array $arguments)
    {
        if (sizeof($arguments) != 1) {
            throw new NumberOfArgumentsException('Error: Expected one argument, got '.sizeof($arguments));
        }

        $number = $arguments[0];

        return tanh($number);
    }

}