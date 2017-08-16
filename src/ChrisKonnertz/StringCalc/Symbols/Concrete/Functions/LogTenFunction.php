<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Functions;

use ChrisKonnertz\StringCalc\Exceptions\NumberOfArgumentsException;
use ChrisKonnertz\StringCalc\Symbols\AbstractFunction;

/**
 * PHP log10() function aka base-10 logarithm.
 * Expects one parameter.
 * @see http://php.net/manual/en/ref.math.php
 */
class LogTenFunction extends AbstractFunction
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['logTen'];

    /**
     * @inheritdoc
     */
    public function execute(array $arguments)
    {
        if (sizeof($arguments) != 1) {
            throw new NumberOfArgumentsException('Error: Expected one argument, got '.sizeof($arguments));
        }

        $number = $arguments[0];

        return log10($number);
    }

}