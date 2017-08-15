<?php

namespace ChrisKonnertz\StringCalc\Grammar;

use ChrisKonnertz\StringCalc\Grammar\Expressions\AbstractExpression;

/**
 * This abstract class represents a grammar. It also is a container for the rules
 * that define this grammar. You may use the constructor of a concrete grammar class
 * as a place to add concrete rules.
 *
 * @package ChrisKonnertz\StringCalc\Grammar
 */
class AbstractGrammar
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