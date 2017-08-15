<?php

namespace ChrisKonnertz\StringCalc\Grammar\Expressions;

/**
 * This expression class is the base class for all expression classes
 * that are containers for other expressions.
 *
 * @package ChrisKonnertz\StringCalc\Grammar\Expressions
 */
abstract class AbstractContainerExpression extends AbstractExpression
{

    /**
     * Array with the expressions.
     * Attention: The order is relevant!
     *
     * @var AbstractExpression[]
     */
    protected $expressions;

    /**
     * AndExpression constructor.
     *
     * @param AbstractExpression[] ...$expressions
     */
    public function __construct(...$expressions)
    {
        $this->setExpressions($expressions);
    }

    /**
     * Getter for the expressions array
     *
     * @return AbstractExpression[]
     */
    public function getExpressions()
    {
        return $this->expressions;
    }

    /**
     * Setter for the expressions array
     *
     * @param AbstractExpression[] $expressions
     */
    public function setExpressions(array $expressions)
    {
        foreach ($expressions as $expression) {
            if (! $expression instanceof AbstractExpression) {
                throw new \InvalidArgumentException(
                    'Error: Expected array of AbstractExpression but got something else'
                );
            }
        }

        $this->expressions = $expressions;
    }

    /**
     * Removes all expressions from the expressions array
     */
    public function removeExpressions()
    {
        $this->expressions = [];
    }

    /**
     * Adds an expression at the end of the expressions array
     *
     * @param AbstractExpression $expression
     */
    public function addExpression(AbstractExpression $expression)
    {
        $this->expressions[] = $expression;
    }

}