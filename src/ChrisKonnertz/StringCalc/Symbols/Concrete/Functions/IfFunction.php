<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Functions;

use ChrisKonnertz\StringCalc\Exceptions\NumberOfArgumentsException;
use ChrisKonnertz\StringCalc\Symbols\AbstractFunction;

/**
 * PHP acos() function aka arc cosine. Expects one parameter.
 * @see http://php.net/manual/en/ref.math.php
 */
class IfFunction extends AbstractFunction
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['if'];

    /**
     * @inheritdoc
     * @throws NumberOfArgumentsException
     */
    public function execute(array $arguments)
    {
        if (sizeof($arguments) != 3) {
            throw new NumberOfArgumentsException('Error: Expected tree arguments, got '.sizeof($arguments));
        }

        $cond = (bool)(int)$arguments[0];
        $ifTrue = $arguments[1];
        $ifFalse = $arguments[2];

        return $cond?$ifTrue:$ifFalse;
    }

}