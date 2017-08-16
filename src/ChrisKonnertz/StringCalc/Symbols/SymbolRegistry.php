<?php

namespace ChrisKonnertz\StringCalc\Symbols;

use ChrisKonnertz\StringCalc\Symbols\Concrete\Brackets\ClosingBracket;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Brackets\OpeningBracket;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\EConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\EulerConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\LnPiConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\LnTenConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\LnTwoConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\LogTenEConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\LogTwoEConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\OnePiConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\PiConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\PiFourConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\PiTwoConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\SqrtOneTwoConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\SqrtPiConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\SqrtThreeConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\SqrtTwoConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\TwoPiConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\TwoSqrtPiConstant;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\AbsFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\ACosFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\ACosHFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\ASinFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\ASinHFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\ATanFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\ATanHFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\ATanTwoFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\CeilFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\CosFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\CosHFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\DegToRadFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\EnFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\ExpFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\ExpMOneFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\FloorFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\FModFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\GetRandMaxFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\HypotFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\LogFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\LogOnePFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\LogTenFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\MaxFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\MinFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\MTGetRandMaxFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\MTRandFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\PowFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\RadToDegFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\RandFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\RoundFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\SinFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\SinHFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\SqrtFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\TanFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\TanHFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Number;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Operators\AdditionOperator;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Operators\DivisionOperator;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Operators\ExponentiationOperator;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Operators\ModuloOperator;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Operators\MultiplicationOperator;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Operators\SubtractionOperator;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Separator;

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
            EConstant::class,
            LogTwoEConstant::class,
            LogTenEConstant::class,
            LnTwoConstant::class,
            LnTenConstant::class,
            PiTwoConstant::class,
            PiFourConstant::class,
            OnePiConstant::class,
            TwoPiConstant::class,
            SqrtPiConstant::class,
            TwoSqrtPiConstant::class,
            SqrtTwoConstant::class,
            SqrtThreeConstant::class,
            SqrtOneTwoConstant::class,
            LnPiConstant::class,
            EulerConstant::class,

            AdditionOperator::class,
            DivisionOperator::class,
            ExponentiationOperator::class,
            ModuloOperator::class,
            MultiplicationOperator::class,
            SubtractionOperator::class,

            AbsFunction::class,
            ACosFunction::class,
            ACosHFunction::class,
            ASinFunction::class,
            ASinHFunction::class,
            ATanFunction::class,
            ATanHFunction::class,
            ATanTwoFunction::class,
            CeilFunction::class,
            CosFunction::class,
            CosHFunction::class,
            DegToRadFunction::class,
            EnFunction::class,
            ExpFunction::class,
            ExpMOneFunction::class,
            FloorFunction::class,
            FModFunction::class,
            GetRandMaxFunction::class,
            HypotFunction::class,
            LogFunction::class,
            LogOnePFunction::class,
            LogTenFunction::class,
            MaxFunction::class,
            MinFunction::class,
            MTGetRandMaxFunction::class,
            MTRandFunction::class,
            PowFunction::class,
            RadToDegFunction::class,
            RandFunction::class,
            RoundFunction::class,
            SinFunction::class,
            SinHFunction::class,
            SqrtFunction::class,
            TanFunction::class,
            TanHFunction::class,
        ];

        return $symbols;
    }

}