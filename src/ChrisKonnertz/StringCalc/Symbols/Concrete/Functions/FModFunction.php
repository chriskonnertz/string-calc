<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Functions;

use ChrisKonnertz\StringCalc\Symbols\AbstractFunction;

/**
 * PHP fmod() function aka returns the floating point
 * emainder (modulo) of the division of the arguments.
 * The first is the dividend param, the second is the
 * divisor param.
 * @see http://php.net/manual/en/ref.math.php
 */
class ATanTwoFunction extends AbstractFunction
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['fMod'];

    /**
     * @inheritdoc
     */
    public function execute(array $arguments)
    {
        if (sizeof($arguments) != 2) {
            throw new \InvalidArgumentException('Error: Expected two argument, got '.sizeof($arguments));
        }

        $firstNumber = $arguments[0];
        $secondNumber = $arguments[1];

        return fmod($firstNumber, $secondNumber);
    }

}