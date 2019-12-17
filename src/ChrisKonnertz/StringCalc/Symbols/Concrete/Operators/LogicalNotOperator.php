<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Operators;

use ChrisKonnertz\StringCalc\Symbols\AbstractOperator;

/**
 * Operator for logical NOT
 * Example: "!1" => 0
 * @see https://www.php.net/manual/en/language.operators.logical.php
 *
 * @package ChrisKonnertz\StringCalc\Symbols\Concrete\Operators
 */
class LogicalNotOperator extends AbstractOperator
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['!'];

    /**
     * @inheritdoc
     */
    const OPERATES_UNARY = true;

    /**
     * @inheritdoc
     */
    const PRECEDENCE = 300;

    /**
     * @inheritdoc
     */
    public function operate($leftNumber, $rightNumber)
    {
        return (int)!((bool)$rightNumber);
    }

}