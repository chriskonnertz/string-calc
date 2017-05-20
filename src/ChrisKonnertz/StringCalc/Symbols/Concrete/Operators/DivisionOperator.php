<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Operators;

use ChrisKonnertz\StringCalc\Symbols\AbstractOperator;

/**
 * Operator for mathematical division.
 * Example: "6/2" => 3, "6/0" => InvalidArgumentException
 * @see https://en.wikipedia.org/wiki/Division_(mathematics)
 *
 * @package ChrisKonnertz\StringCalc\Symbols\Concrete
 */
class DivisionOperator extends AbstractOperator
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['/'];

    /**
     * @inheritdoc
     */
    const PRECEDENCE = 200;

    /**
     * @inheritdoc
     */
    public function operate($leftNumber, $rightNumber)
    {
        // TODO: Is this expression true for imprecise floats?
        if ($rightNumber == 0) {
            throw new \InvalidArgumentException('Error: Division by zero detected.');
        }

        return $leftNumber / $rightNumber;
    }

}