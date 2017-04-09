<?php

namespace ChrisKonnertz\StringCalc\Parser;
use ChrisKonnertz\StringCalc\Symbols\AbstractOperator;

/**
 * An array node is a (sorted) array of nodes
 *
 * @package ChrisKonnertz\StringCalc\Parser
 */
class ArrayNode extends AbstractNode
{

    /**
     * Array of (sorted) nodes
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
        $this->setNodes($nodes);
    }

    /**
     * Setter for the sub nodes.
     *
     * @param array $nodes
     */
    protected function setNodes(array $nodes)
    {
        // Ensure integrity of $nodes array
        foreach ($nodes as $node) {
            if (! is_a($node, AbstractNode::class)) {
                throw new \InvalidArgumentException('Error: Expected AbstractNode, got something else.');
            }
        }

        $this->nodes = $nodes;

        $this->sortByPrecedence();
    }

    /**
     * Sorts the nodes. Attention: Does not sort the sub nodes!
     * Every ArrayNode is only responsible for its level-0-nodes.
     */
    protected function sortByPrecedence()
    {
        foreach ($this->nodes as $index => $node) {
            if (is_a($node, SymbolNode::class)) {
                /** @var $node SymbolNode */
                $symbol = $node->getSymbol();
                if (is_a($symbol, AbstractOperator::class)) {
                    $unary = constant(AbstractOperator::class.'::OPERATES_UNARY');
                    $binary = constant(AbstractOperator::class.'::OPERATES_BINARY');

                    throw new \Exception('NOT YET IMPLEMENTED, PLEASE IMPLEMENT ME!'); // TODO FIXME implement this!
                }
            }
        }
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

    /**
     * Returns true if the array nodes does not have any
     * sub nodes.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return ($this->size() == 0);
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

}