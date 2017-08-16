<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Functions;

use ChrisKonnertz\StringCalc\Exceptions\NumberOfArgumentsException;
use ChrisKonnertz\StringCalc\Symbols\AbstractFunction;

/**
 * PHP log() function aka natural logarithm.
 * Expects one or two parameters. The second
 * parameter is the optional logarithmic base
 * to use. Defaults to PHP M_E.
 * @see http://php.net/manual/en/ref.math.php
 */
class LogFunction extends AbstractFunction
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['log'];

    /**
     * @inheritdoc
     */
    public function execute(array $arguments)
    {
        if (sizeof($arguments) == 0 or sizeof($arguments) > 2) {
            throw new NumberOfArgumentsException('Error: Expected one or two arguments, got '.sizeof($arguments));
        }

        $number = $arguments[0];
        $base = M_E;

        if (sizeof($arguments) == 2) {
            $base = $arguments[1];
        }

        return log($number, $base);
    }

}