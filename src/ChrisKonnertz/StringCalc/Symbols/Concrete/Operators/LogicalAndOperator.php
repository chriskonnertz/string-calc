<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Operators;

use ChrisKonnertz\StringCalc\Symbols\AbstractOperator;

/**
 * Operator for logical AND
 * Example: "1&&0" => 0
 * @see https://www.php.net/manual/en/language.operators.logical.php
 *
 * @package ChrisKonnertz\StringCalc\Symbols\Concrete\Operators
 */
class LogicalAndOperator extends AbstractOperator
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['&&'];

    /**
     * @inheritdoc
     */
    const PRECEDENCE = 65;

    /**
     * @inheritdoc
     */
    public function operate($leftNumber, $rightNumber)
    {
        return (int)((bool)$leftNumber && (bool)$rightNumber);
    }

}