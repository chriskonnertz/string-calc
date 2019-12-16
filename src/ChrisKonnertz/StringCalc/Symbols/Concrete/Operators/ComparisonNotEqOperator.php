<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Operators;

use ChrisKonnertz\StringCalc\Symbols\AbstractOperator;

/**
 * Operator for comparison '!='
 * Example: "1==2" => 1
 * @see https://www.php.net/manual/en/language.operators.comparison.php
 *
 * @package ChrisKonnertz\StringCalc\Symbols\Concrete\Operators
 */
class ComparisonNotEqOperator extends AbstractOperator
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['!='];

    /**
     * @inheritdoc
     */
    const PRECEDENCE = 85;

    /**
     * @inheritdoc
     */
    public function operate($leftNumber, $rightNumber)
    {
        return (int)($leftNumber != $rightNumber);
    }

}