<?php namespace ChrisKonnertz\StringCalc\Symbols;

/**
 * This class is the base class for all symbols that are of the type "constant".
 * We recommend to use names as textual represenations for this type of symbol.
 * Please take note of the fact that the precision of PHP float constants 
 * (for example M_PI) is based on the "precision" directive in php.ini, 
 * which defaults to 14.
 */
abstract class AbstractConstant extends Symbol {
    
    /**
     * This is the value of the constant. We use 0 as an example here,
     * but you are supposed to overwrite this in the concrete constant class.
     * Usually mathematical constants are not integers, however,
     * you are allowed to use an integer in this context.
     * @const int|float
     */
    const VALUE = 0;

    /**
     * Typically the value of the constant should be stored in self::VALUE.
     * However, in case you want to calculate the value at runtime,
     * feel free to overwrite this getter method.
     * @return int|float
     */
    public function getValue()
    {
        return self::VALUE;
    }

}