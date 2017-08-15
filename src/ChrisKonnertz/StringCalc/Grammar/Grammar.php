<?php

namespace ChrisKonnertz\StringCalc\Grammar;

use ChrisKonnertz\StringCalc\Grammar\Expressions\AbstractExpression;
use ChrisKonnertz\StringCalc\Grammar\Expressions\AndExpression;
use ChrisKonnertz\StringCalc\Grammar\Expressions\OptionalAndExpression;
use ChrisKonnertz\StringCalc\Grammar\Expressions\OrExpression;
use ChrisKonnertz\StringCalc\Grammar\Expressions\RepeatedAndExpression;
use ChrisKonnertz\StringCalc\Grammar\Expressions\SymbolExpression;

/**
 * This class represents a grammar. It also is a container for the rules
 * that define this grammar.
 *
 * @package ChrisKonnertz\StringCalc\Grammar
 */
class Grammar
{

    /**
     * Production rules of the grammar, will be filled at runtime
     *
     * @var Rule[]
     */
    protected $rules = [];

    /**
     * The name of the symbol that defines
     * the start for the production rules
     *
     * @var string
     */
    protected $start = null;

    public function __construct()
    {
        // Define the symbols
        $expression = new SymbolExpression('expression');
        $number = new SymbolExpression('number');
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
            $expression,
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

    /**
     * Adds a new production rule to the set of rules
     *
     * @param string $symbolName The name of the nonterminal symbol on the left side of the rule
     * @param AbstractExpression $expression The expression that represents the right side of the rule
     */
    public function addRule($symbolName, AbstractExpression $expression)
    {
        $rule = new Rule($symbolName, $expression);
        $this->rules[] = $rule;
    }

    /**
     * Setter fot the start property
     *
     * @param $symbolName
     */
    public function setStart($symbolName)
    {
        $this->start = $symbolName;
    }

    /**
     * Getter for the rules
     *
     * @return Rule[]
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * Returns the whole grammar (or to be more precise, its rules) as a string
     *
     * @return string
     */
    public function __toString()
    {
        $parts = [];

        foreach ($this->rules as $rule) {
            $parts[] = $rule->__toString();
        }

        return implode(' '.PHP_EOL, $parts);
    }

}