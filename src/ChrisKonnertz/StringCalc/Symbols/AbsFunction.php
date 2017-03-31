<?php namespace ChrisKonnertz\StringCalc\Symbols;

/**
 * PHP abs() function
 */
class AbsFunction extends AbstractFunction {

    protected $textualRepresentations = ['abs'];

    const NUMBER_OF_ARGUMENTS = 1;
    
    public function execute(array $arguments) 
    {
        $number = $arguments[0];
        return abs($number);
    }

}