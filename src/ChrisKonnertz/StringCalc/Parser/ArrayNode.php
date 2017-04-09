<?php

namespace ChrisKonnertz\StringCalc\Parser;

/**
 * An array node is an array of nodes
 *
 * @package ChrisKonnertz\StringCalc\Parser
 */
class ArrayNode extends AbstractNode
{

    /**
     * Array of nodes
     *
     * @var AbstractNode[]
     */
    protected $nodes;

    /**
     * ArrayNode constructor.
     *
     * @param AbstractNode[] $nodes
     */
    public function __construct(array $nodes)
    {
        // Ensure integrity of $nodes array
        foreach ($nodes as $node) {
            if (! is_a($node, AbstractNode::class)) {
                throw new \InvalidArgumentException('Error: Expected AbstractNode, got something else.');
            }
        }

        $this->sortByPrecedence();

        $this->nodes = $nodes;
    }

    /**
     * Sorts the nodes. Attention: Does not sort the sub nodes!
     * Every ArrayNode is only responsible for its level-0-nodes.
     */
    protected function sortByPrecedence()
    {

    }

    /**
     * Getter for the sub nodes
     *
     * @return AbstractNode[]
     */
    public function getNodes()
    {
        return $this->nodes;
    }

    /**
     * Returns the number of (sub) nodes in this array node.
     * Does not count the sub nodes of the sub nodes.
     *
     * @return int
     */
    public function size()
    {
        return sizeof($this->nodes);
    }

}