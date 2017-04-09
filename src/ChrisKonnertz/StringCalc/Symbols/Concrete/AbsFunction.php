<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete;

use ChrisKonnertz\StringCalc\Symbols\AbstractFunction;

/**
 * PHP abs() function
 */
class AbsFunction extends AbstractFunction
{

    /**
     * @inheritdoc
     */
    protected $identifier = ['abs'];

    /**
     * @inheritdoc
     */
    const NUMBER_OF_ARGUMENTS = 1;

    /**
     * @inheritdoc
     */
    public function execute(array $arguments)
    {
        $number = $arguments[0];

        return abs($number);
    }

}