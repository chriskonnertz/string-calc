<?php

namespace ChrisKonnertz\StringCalc\Grammar\Expressions;

/**
 * This is a container expression. The expressions that it contains are
 * linked with an AND. They (as a whole) will be repeated for given times.
 *
 * @package ChrisKonnertz\StringCalc\Grammar\Expressions
 */
class RepeatedAndExpression extends AbstractContainerExpression
{

    /**
     * Minimum of repetitions, >= 0
     *
     * @var int
     */
    protected $min = 0;

    /**
     * Maximum of repetitions, <= 0
     * @var int
     */
    protected $max = PHP_INT_MAX;

    /**
     * RepeatedAndExpression constructor.
     *
     * @param int $min 0...PHP_INT_MAX, must be <= $max
     * @param int $max 0...PHP_INT_MAX, must be >= $min
     * @param AbstractExpression[] ...$expressions
     */
    public function __construct($min, $max, ...$expressions)
    {
        $this->setMin($min);
        $this->setMax($max);

        parent::__construct(...$expressions);
    }

    /**
     * Setter for min
     *
     * @return int
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * Getter for min
     *
     * @param int $min
     */
    public function setMin($min)
    {
        $min = (int) $min;

        if ($min < 0) {
            throw new \InvalidArgumentException('Error: Minimum cannot be smaller than zero');
        }
        if ($min > $this->max) {
            // We do not throw an exception but silently adjust the maximum.
            $this->max = $min;
        }

        $this->min = $min;
    }

    /**
     * Getter for max
     *
     * @return int
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * Setter for max
     *
     * @param int $max
     */
    public function setMax($max)
    {
        $max = (int) $max;

        if ($max < 0) {
            throw new \InvalidArgumentException('Error: Maximum cannot be smaller than zero');
        }
        if ($max < $this->min) {
            // We do not throw an exception but silently adjust the minimum.
            $this->min = $max;
        }

        $this->max = $max;
    }

    public function __toString()
    {
        $parts = [];

        foreach ($this->expressions as $expression) {
            $parts[] = $expression->__toString();
        }

        if ($this->min == 0 and $this->max == PHP_INT_MAX) {
            $repetitions = '*';
        } else {
            $repetitions = $this->min.'-'.$this->max;
        }

        return '( '.implode(' ', $parts).' )'.$repetitions;
    }

}
