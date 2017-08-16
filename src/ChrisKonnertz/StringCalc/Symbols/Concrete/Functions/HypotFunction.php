<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Functions;

use ChrisKonnertz\StringCalc\Exceptions\NumberOfArgumentsException;
use ChrisKonnertz\StringCalc\Symbols\AbstractFunction;

/**
 * PHP hypot() function aka calculate the length
 * of the hypotenuse of a right-angle triangle.
 * The first is the length of the first side,
 * the second is the length of the second side.
 *
 * @see http://php.net/manual/en/ref.math.php
 */
class HypotFunction extends AbstractFunction
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['hypot'];

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

        return hypot($firstNumber, $secondNumber);
    }

}