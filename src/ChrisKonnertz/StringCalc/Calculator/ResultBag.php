<?php

namespace ChrisKonnertz\StringCalc\Calculator;

use ChrisKonnertz\StringCalc\Parser\AbstractNode;

/**
 * The result bag class is used during calculation.
 * It stores two properties: A node object from
 * the syntax tree and the (calculated) result of
 * this node.
 *
 * @package ChrisKonnertz\StringCalc\Calculator
 */
class ResultBag
{

    /**
     * @var AbstractNode
     */
    protected $node;

    /**
     * The numeric value / result of a (sub) calculation.
     * Attention: Might be null.
     * Null indicates that is has not been calculated yet!
     *
     * @var int|float|null
     */
    protected $result;

    /**
     * ResultBag constructor.
     *
     * @param AbstractNode $node
     * @param float|int    $result
     */
    public function __construct(AbstractNode $node, $result = null)
    {
        $this->node = $node;

        $this->result = $result;
    }

    /**
     * Getter for the node property.
     *
     * @return AbstractNode
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * Setter for the node property.
     *
     * @param AbstractNode $node
     */
    public function setNode($node)
    {
        $this->node = $node;
    }

    /**
     * Getter for the result property.
     * Attention: Might return null!
     *
     * @return float|int|null
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Setter for the result property.
     *
     * @param float|int|null $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

}