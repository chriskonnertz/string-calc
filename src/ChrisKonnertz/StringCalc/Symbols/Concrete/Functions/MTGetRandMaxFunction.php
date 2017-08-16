<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Functions;

use ChrisKonnertz\StringCalc\Exceptions\NumberOfArgumentsException;
use ChrisKonnertz\StringCalc\Symbols\AbstractFunction;

/**
 * PHP mt_getrandmax() function aka return largest
 * possible random value that can be returned by a
 * call to PHP mt_rand(). Expects one parameter.
 * @see http://php.net/manual/en/ref.math.php
 */
class MTGetRandMaxFunction extends AbstractFunction
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['mTGetRandMax'];

    /**
     * @inheritdoc
     */
    public function execute(array $arguments)
    {
        if (sizeof($arguments) > 0) {
            throw new NumberOfArgumentsException('Error: Expected no arguments, got '.sizeof($arguments));
        }

        return mt_getrandmax();
    }

}