<?php

namespace ChrisKonnertz\StringCalc\Grammar\Expressions;

/**
 * This is a container expression. The expressions that it contains are
 * linked with an AND. They (as a whole) will be repeated for min n and max m times.
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
     * @param int $min
     * @param int $max
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

        if ($min > $this->max) {
            throw new \InvalidArgumentException('Error: Minimum cannot be grater than maximum');
        }
        if ($min < 0) {
            throw new \InvalidArgumentException('Error: Minimum cannot be smaller than zero');
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

        if ($max < $this->min) {
            throw new \InvalidArgumentException('Error: maximum cannot be smaller than maximum');
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