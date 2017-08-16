<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Functions;

use ChrisKonnertz\StringCalc\Exceptions\NumberOfArgumentsException;
use ChrisKonnertz\StringCalc\Symbols\AbstractFunction;

/**
 * PHP floor() function aka round fractions down.
 * Expects one parameter.
 * @see http://php.net/manual/en/ref.math.php
 */
class FloorFunction extends AbstractFunction
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['floor'];

    /**
     * @inheritdoc
     */
    public function execute(array $arguments)
    {
        if (sizeof($arguments) != 1) {
            throw new NumberOfArgumentsException('Error: Expected one argument, got '.sizeof($arguments));
        }

        $number = $arguments[0];

        return floor($number);
    }

}