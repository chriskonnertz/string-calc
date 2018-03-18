<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Operators;

use ChrisKonnertz\StringCalc\Symbols\AbstractOperator;

/**
 * Operator for mathematical division.
 * Example: "6/2" => 3, "6/0" => http://php.net/manual/en/class.divisionbyzeroerror.php
 * @see https://en.wikipedia.org/wiki/Division_(mathematics)
 *
 * @package ChrisKonnertz\StringCalc\Symbols\Concrete\Operators
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
        return $leftNumber / $rightNumber;
    }

}
