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
     * TODO Remove this code to a better place!
     * Sorts the nodes. Attention: Does not sort the sub nodes!
     * Every ArrayNode is only responsible for its level-0-nodes.
     */
    protected function sortByPrecedence()
    {
        $operators = [];

        foreach ($this->childNodes as $index => $childNodes) {
            if (is_a($childNodes, SymbolNode::class)) {
                /** @var $node SymbolNode */
                $symbol = $node->getSymbol();
                if (is_a($symbol, AbstractOperator::class)) {
                    $unary = constant(AbstractOperator::class.'::OPERATES_UNARY');
                    $binary = constant(AbstractOperator::class.'::OPERATES_BINARY');

                    $operators[] = $childNodes;
                }
            }
        }

        // Using Quicksort to sort the operators according to their precedence
        usort($operators, function(SymbolNode $nodeOne, SymbolNode $nodeTwo)
        {

            $symbolOne = $nodeOne->getSymbol();
            $precedenceOne = constant(get_class($symbolOne).'::PRECEDENCE');

            $symbolTwo = $nodeTwo->getSymbol();
            $precedenceTwo = constant(get_class($symbolTwo).'::PRECEDENCE');

            if ($precedenceOne == $precedenceTwo) {
                return 0;
            }
            return ($precedenceOne < $precedenceTwo) ? 1 : -1;
        });
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