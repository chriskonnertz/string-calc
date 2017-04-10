<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete;

use ChrisKonnertz\StringCalc\Symbols\AbstractOperator;

class MultiplicationOperator extends AbstractOperator
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['*'];

    /**
     * @inheritdoc
     */
    const PRECEDENCE = 200;

    /**
     * @inheritdoc
     */
    public function operate($leftNumber, $rightNumber)
    {
        return $leftNumber * $rightNumber;
    }

}