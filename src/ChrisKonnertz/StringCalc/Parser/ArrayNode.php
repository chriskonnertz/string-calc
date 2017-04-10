<?php

namespace ChrisKonnertz\StringCalc\Parser;
use ChrisKonnertz\StringCalc\Symbols\AbstractOperator;

/**
 * An array node is a container for a (sorted) array of nodes
 *
 * @package ChrisKonnertz\StringCalc\Parser
 */
class ArrayNode extends AbstractNode
{

    /**
     * Array of (sorted) child nodes
     *
     * @var AbstractNode[]
     */
    protected $childNodes;

    /**
     * ArrayNode constructor.
     *
     * @param AbstractNode[] $childNodes
     */
    public function __construct(array $childNodes)
    {
        $this->setChildNodes($childNodes);
    }

    /**
     * Setter for the child nodes.
     *
     * @param AbstractNode[] $childNodes
     */
    public function setChildNodes(array $childNodes)
    {
        // Ensure integrity of $nodes array
        foreach ($childNodes as $childNode) {
            if (! is_a($childNode, AbstractNode::class)) {
                throw new \InvalidArgumentException('Error: Expected AbstractNode, got something else.');
            }
        }

        $this->childNodes = $childNodes;
    }

    /**
     * Returns the number of child nodes in this array node.
     * Does not count the child nodes of the child nodes.
     *
     * @return int
     */
    public function size()
    {
        return sizeof($this->childNodes);
    }

    /**
     * Returns true if the array node does not have any
     * child nodes.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return ($this->size() == 0);
    }

    /**
     * Getter for the child nodes
     *
     * @return AbstractNode[]
     */
    public function getChildNodes()
    {
        return $this->childNodes;
    }

}