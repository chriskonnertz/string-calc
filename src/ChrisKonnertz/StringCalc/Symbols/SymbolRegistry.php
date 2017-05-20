<?php

namespace ChrisKonnertz\StringCalc\Symbols;

use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\AbsFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Operators\AdditionOperator;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Brackets\ClosingBracket;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Operators\DivisionOperator;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Operators\ExponentiationOperator;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\MaxFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\MinFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Operators\MultiplicationOperator;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Number;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Brackets\OpeningBracket;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\PiConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Separator;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Operators\SubtractionOperator;

/**
 * This class has one simple job: It contains an array with the names
 * of the initially registered symbols. It does not offer an add()
 * method - but you can add new symbols via the addSymbol() method of
 * the StringCalc class.
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

            Separator::class,

            ClosingBracket::class,
            OpeningBracket::class,

            PiConstant::class,

            AdditionOperator::class,
            DivisionOperator::class,
            ExponentiationOperator::class,
            MultiplicationOperator::class,
            SubtractionOperator::class,

            AbsFunction::class,
            MinFunction::class,
            MaxFunction::class,
        ];

        return $symbols;
    }

}