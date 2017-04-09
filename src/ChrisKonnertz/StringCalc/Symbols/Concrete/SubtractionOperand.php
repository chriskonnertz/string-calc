<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete;

use ChrisKonnertz\StringCalc\Symbols\AbstractOperand;

class SubtractionOperand extends AbstractOperand
{

    /**
     * @inheritdoc
     */
    protected $identifier = ['+'];

    /**
     * @inheritdoc
     */
    const PRECEDENCE = 0;

    /**
     * @inheritdoc
     */
    public function operate($leftNumber, $rightNumber)
    {
        return $leftNumber - $rightNumber;
    }

}