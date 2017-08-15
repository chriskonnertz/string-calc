<?php

namespace ChrisKonnertz\StringCalc\Grammar;

use ChrisKonnertz\StringCalc\Grammar\Expressions\AbstractExpression;

/**
 * Rule class that represents a (simplified) production rule of the grammar.
 *
 * @package ChrisKonnertz\StringCalc\Grammar
 */
class Rule
{

    /**
     * String used to separate the left and the right side of the rule
     * when it is printed as a string
     */
    const SIDE_SEPARATOR = ':=';

    /**
     * This is the left side of the rule. We simplify rules by
     * only allowing one nonterminal symbol on the left side of the rule.
     * We store its name in this property.
     *
     * @var string
     */
    protected $nonterminalSymbolName = '';

    /**
     * This is the right side of the rule. It is described by an
     * Expression object which can contain other expression objects.
     *
     * @var AbstractExpression
     */
    protected $expression = null;

    /**
     * AbstractRule constructor.
     *
     * @param string             $nonterminalSymbolName
     * @param AbstractExpression $expression
     */
    public function __construct($nonterminalSymbolName, AbstractExpression $expression)
    {
        $this->nonterminalSymbolName = $nonterminalSymbolName;
        $this->expression = $expression;
    }

    /**
     * Getter for the name of the nonterminal symbol
     *
     * @return string
     */
    public function getNonterminalSymbolName()
    {
        return $this->nonterminalSymbolName;
    }

    /**
     * Setter for the name of the nonterminal symbol
     *
     * @param string $nonterminalSymbolName
     */
    public function setNonterminalSymbolName($nonterminalSymbolName)
    {
        $this->nonterminalSymbolName = $nonterminalSymbolName;
    }

    /**
     * Getter for the expression
     *
     * @return AbstractExpression
     */
    public function getExpression()
    {
        return $this->expression;
    }

    /**
     * Setter for the expression
     *
     * @param AbstractExpression $expression
     */
    public function setExpression($expression)
    {
        $this->expression = $expression;
    }

    public function __toString()
    {
        return $this->nonterminalSymbolName.' '.self::SIDE_SEPARATOR.' '.$this->expression->__toString();
    }

}