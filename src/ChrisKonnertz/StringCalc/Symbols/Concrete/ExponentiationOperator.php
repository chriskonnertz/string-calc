<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete;

use ChrisKonnertz\StringCalc\Symbols\AbstractOperator;

/**
 * Operator for mathematical exponentiation.
 * Example: "3^2" => 9, "-3^2" => -9, "3^-2" equals "3^(-2)"
 *
 * @package ChrisKonnertz\StringCalc\Symbols\Concrete *
 */
class ExponentiationOperator extends AbstractOperator
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['^'];

    /**
     * @inheritdoc
     */
    const PRECEDENCE = 300;

    /**
     * @inheritdoc
     */
    public function operate($leftNumber, $rightNumber)
    {
        return pow($leftNumber, $rightNumber);
    }

}