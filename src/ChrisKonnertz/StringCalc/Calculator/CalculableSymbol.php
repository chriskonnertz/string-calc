<?php

namespace ChrisKonnertz\StringCalc\Calculator;

use ChrisKonnertz\StringCalc\Parser\Nodes\AbstractNode;

/**
 * The CalculableSymbol class is used during calculation
 * and typically part of a linked list of calculable symbols.
 *
 * @package ChrisKonnertz\StringCalc\Calculator
 */
class CalculableSymbol
{

    /**
     * The numeric value / result of a (sub) calculation.
     *
     * @var int|float
     */
    protected $value;

    /**
     * @var CalculableSymbol|null
     */
    protected $previous = null;

    /**
     * @var CalculableSymbol|null
     */
    protected $next = null;

    /**
     * CalculableSymbol constructor.
     *
     * @param int|float $value
     */
    public function __construct($value)
    {
        $this->setValue($value);
    }

    /**
     * Getter for the value property.
     *
     * @return int|float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Setter for the value property.
     *
     * @param int|float $value
     */
    public function setValue($value)
    {
        if (! is_numeric($value)) {
            throw new \InvalidArgumentException('Error: Argument type is not numeric.');
        }

        $this->value = $value;
    }

    /**
     * Getter for the previous calculable symbol in the linked list
     *
     * @return CalculableSymbol|null
     */
    public function getPrevious()
    {
        return $this->previous;
    }

    /**
     * Setter for the previous calculable symbol in the linked list
     *
     * @param CalculableSymbol|null $previous
     */
    public function setPrevious($previous)
    {
        $this->previous = $previous;
    }

    /**
     * Getter for the next calculable symbol in the linked list
     *
     * @return CalculableSymbol|null
     */
    public function getNext()
    {
        return $this->next;
    }

    /**
     * Setter for the next calculable symbol in the linked list
     *
     * @param CalculableSymbol|null $next
     */
    public function setNext($next)
    {
        $this->next = $next;
    }

}