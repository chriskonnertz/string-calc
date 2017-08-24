<?php

namespace ChrisKonnertz\StringCalc\Grammar;

use ChrisKonnertz\StringCalc\Grammar\Expressions\AndExpression;
use ChrisKonnertz\StringCalc\Grammar\Expressions\OptionalAndExpression;
use ChrisKonnertz\StringCalc\Grammar\Expressions\OrExpression;
use ChrisKonnertz\StringCalc\Grammar\Expressions\RepeatedAndExpression;
use ChrisKonnertz\StringCalc\Grammar\Expressions\SymbolExpression;

/**
 * This class represents the concrete grammar of StringCalc.
 * It also is a container for the rules that define this grammar.
 *
 * @package ChrisKonnertz\StringCalc\Grammar
 */
class StringCalcGrammar extends AbstractGrammar
{

    public function __construct()
    {
        // Define the symbols
        $expression = new SymbolExpression('expression');
        $simpleExpression = new SymbolExpression('simpleExpression');
        $number = new SymbolExpression('number'); // Note: A number cannot be negative!
        $constant = new SymbolExpression('constant');
        $function = new SymbolExpression('function');
        $openingBracket = new SymbolExpression('openingBracket');
        $closingBracket = new SymbolExpression('closingBracket');
        $operator = new SymbolExpression('operator');
        $unaryOperator = new SymbolExpression('unaryOperator');
        $functionBody = new SymbolExpression('functionBody');
        $argumentSeparator = new SymbolExpression('argumentSeparator');

        // Define the rules
        $this->addRule($expression->getSymbolName(), new OrExpression($number, $constant, $function));
        $this->addRule($expression->getSymbolName(), new AndExpression($openingBracket, $expression, $closingBracket));
        $this->addRule($expression->getSymbolName(), new AndExpression(
            new OptionalAndExpression($unaryOperator),
            $simpleExpression,
            new RepeatedAndExpression(
                0, PHP_INT_MAX, $operator, new OptionalAndExpression($unaryOperator), $simpleExpression
            )
        ));
        $this->addRule($simpleExpression->getSymbolName(), new OrExpression($number, $constant, $function));
        $this->addRule($simpleExpression->getSymbolName(), new AndExpression(
            $openingBracket,
            $expression,
            $closingBracket
        ));
        $this->addRule($simpleExpression->getSymbolName(), new AndExpression(
            $simpleExpression,
            new RepeatedAndExpression(
                0, PHP_INT_MAX, $operator, new OptionalAndExpression($unaryOperator), $expression
            )
        ));
        $this->addRule($function->getSymbolName(), new AndExpression($functionBody, $openingBracket, $closingBracket));
        $this->addRule($function->getSymbolName(), new AndExpression(
            $functionBody,
            $openingBracket,
            $expression,
            new RepeatedAndExpression(0, PHP_INT_MAX, $argumentSeparator, $expression),
            $closingBracket
        ));

        // Define the start
        $this->start = $expression->getSymbolName();
    }

}