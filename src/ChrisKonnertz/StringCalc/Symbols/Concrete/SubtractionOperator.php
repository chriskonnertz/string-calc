<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete;

use ChrisKonnertz\StringCalc\Symbols\AbstractOperator;

class SubtractionOperator extends AbstractOperator
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
     * The subtraction operator is unary AND binary!
     */
    const UNARY = true;

    /**
     * @inheritdoc
     */
    public function operate($leftNumber, $rightNumber)
    {
        return $leftNumber - $rightNumber;
    }

}