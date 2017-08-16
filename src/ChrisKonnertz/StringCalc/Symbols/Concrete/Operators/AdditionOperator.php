<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Operators;

use ChrisKonnertz\StringCalc\Symbols\AbstractOperator;

/**
 * Operator for mathematical addition.
 * Example: "1+2" => 3
 * @see https://en.wikipedia.org/wiki/Addition
 *
 * @package ChrisKonnertz\StringCalc\Symbols\Concrete\Operators
 */
class AdditionOperator extends AbstractOperator
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['+'];

    /**
     * @inheritdoc
     */
    const PRECEDENCE = 100;

    /**
     * @inheritdoc
     */
    public function operate($leftNumber, $rightNumber)
    {
        return $leftNumber + $rightNumber;
    }

}