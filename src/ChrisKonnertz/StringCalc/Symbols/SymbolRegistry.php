<?php

namespace ChrisKonnertz\StringCalc\Symbols;

use ChrisKonnertz\StringCalc\Symbols\Concrete\AbsFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\AdditionOperand;
use ChrisKonnertz\StringCalc\Symbols\Concrete\ClosingBracket;
use ChrisKonnertz\StringCalc\Symbols\Concrete\DivisionOperand;
use ChrisKonnertz\StringCalc\Symbols\Concrete\MultiplicationOperand;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Number;
use ChrisKonnertz\StringCalc\Symbols\Concrete\OpeningBracket;
use ChrisKonnertz\StringCalc\Symbols\Concrete\PiConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\SubtractionOperand;

/**
 * This class has one simple job: It contains an array with the names
 * of the initially registered symbols. It does not offer an add()
 * method - you can add new symbols via the addSymbol() method of the
 * StringCalc class.
 *
 * @package ChrisKonnertz\StringCalc\Symbols
 */
class SymbolRegistry
{

    /**
     * This method has to return an array with the class names of all registered
     * symbols. Symbols have to inherit from the AbstractSymbol class.
     *
     * @return string[]
     */
    public function getSymbols()
    {
        $symbols = [
            Number::class,

            ClosingBracket::class,
            OpeningBracket::class,

            PiConstant::class,

            AdditionOperand::class,
            DivisionOperand::class,
            MultiplicationOperand::class,
            SubtractionOperand::class,

            AbsFunction::class,
        ];

        return $symbols;
    }

}