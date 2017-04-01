<?php namespace ChrisKonnertz\StringCalc\Symbols;

class DivisionOperand extends AbstractOperand
{

    protected $textualRepresentations = ['/'];

    const PRECEDENCE = 0;

    public function operate($leftNumber, $rightNumber)
    {
        return $leftNumber / $rightNumber;
    }

}