<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Operators;

use ChrisKonnertz\StringCalc\Symbols\AbstractOperator;

/**
 * Operator for mathematical modulo operation.
 * Example: "5%3" => 2
 * @see https://en.wikipedia.org/wiki/Modulo_operation
 *
 * @package ChrisKonnertz\StringCalc\Symbols\Concrete\Operators
 */
class ModuloOperator extends AbstractOperator
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['%'];

    /**
     * @inheritdoc
     */
    const PRECEDENCE = 200;

    /**
     * @inheritdoc
     */
    public function operate($leftNumber, $rightNumber)
    {
        return $leftNumber % $rightNumber;
    }

}