<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete;

use ChrisKonnertz\StringCalc\Symbols\AbstractOperator;

class AdditionOperator extends AbstractOperator
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['+'];

    /**
     * @inheritdoc
     */
    const PRECEDENCE = 0;

    /**
     * @inheritdoc
     */
    public function operate($leftNumber, $rightNumber)
    {
        return $leftNumber + $rightNumber;
    }

}