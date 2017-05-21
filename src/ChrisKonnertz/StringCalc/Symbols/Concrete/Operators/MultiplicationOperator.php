<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Operators;

use ChrisKonnertz\StringCalc\Symbols\AbstractOperator;

/**
 * Operator for mathematical multiplication.
 * Example: "2*3" => 6
 * @see https://en.wikipedia.org/wiki/Multiplication
 *
 * @package ChrisKonnertz\StringCalc\Symbols\Concrete
 */
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
