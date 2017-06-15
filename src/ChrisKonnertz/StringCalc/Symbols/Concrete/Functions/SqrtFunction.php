<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Functions;

use ChrisKonnertz\StringCalc\Symbols\AbstractFunction;

/**
 * PHP sqrt() function aka square root.
 * Expects one parameter.
 * @see http://php.net/manual/en/ref.math.php
 */
class SqrtFunction extends AbstractFunction
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['sqrt'];

    /**
     * @inheritdoc
     */
    public function execute(array $arguments)
    {
        if (sizeof($arguments) != 1) {
            throw new \InvalidArgumentException('Error: Expected one argument, got '.sizeof($arguments));
        }

        $number = $arguments[0];

        if ($number < 0) {
            throw new \InvalidArgumentException('Error: Cannot calculate square root of negative number.');
        }

        return sqrt($number);
    }

}