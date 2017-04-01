<?php namespace ChrisKonnertz\StringCalc\Symbols\Concrete;

use ChrisKonnertz\StringCalc\Symbols\AbstractOperand;

class AdditionOperand extends AbstractOperand
{

    /**
     * @inheritdoc
     */
    protected $textualRepresentations = ['+'];

    /**
     * @inheritdoc
     */
    const PRECEDENCE = 0;

    /**
     * @inheritdoc
     */
    public function operate($leftNumber, $rightNumber)
    {
        return $leftNumber + $rightNumber;
    }

}