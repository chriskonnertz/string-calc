<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Functions;

use ChrisKonnertz\StringCalc\Symbols\AbstractFunction;

/**
 * PHP intdiv() function aka integer division.
 * Expects two parameters. The first is the
 * number to be divided, the second is the
 * number which divides the dividend.
 * @see http://php.net/manual/en/ref.math.php
 */
class IntDivFunction extends AbstractFunction
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['intDiv'];

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

        return intdiv($firstNumber, $secondNumber);
    }

}