<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Operators;

use ChrisKonnertz\StringCalc\Symbols\AbstractOperator;

/**
 * Operator for mathematical multiplication.
 * Example: "1+2" => 3
 * @see https://en.wikipedia.org/wiki/Multiplication
 *
 * @package ChrisKonnertz\StringCalc\Symbols\Concrete\Operators
 */
class SubtractionOperator extends AbstractOperator
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['-'];

    /**
     * @inheritdoc
     */
    const PRECEDENCE = 100;

    /**
     * @inheritdoc
     * Notice: The subtraction operator is unary AND binary!
     */
    const OPERATES_UNARY = true;

    /**
     * @inheritdoc
     */
    public function operate($leftNumber, $rightNumber)
    {
        return $leftNumber - $rightNumber;
    }

}