<?php

namespace ChrisKonnertz\StringCalc\Parser\Nodes;

use Closure;

/**
 * A parent node is a container for a (sorted) array of nodes.
 * Notice: Do not mix this class up with the service container class.
 *
 * @package ChrisKonnertz\StringCalc\Parser
 */
class ContainerNode extends AbstractNode
{

    /**
     * Array of (sorted) child nodes
     * Notice: The number of child nodes can be 0.
     *
     * @var AbstractNode[]
     */
    protected $childNodes;

    /**
     * ContainerNode constructor.
     *
     * @param AbstractNode[] $childNodes
     */
    public function __construct(array $childNodes)
    {
        $this->setChildNodes($childNodes);
    }

    /**
     * Setter for the child nodes.
     * Notice: The number of child nodes can be 0.
     *
     * @param AbstractNode[] $childNodes
     */
    public function setChildNodes(array $childNodes)
    {
        // Ensure integrity of $nodes array
        foreach ($childNodes as $childNode) {
            if (! is_a($childNode, AbstractNode::class)) {
                throw new \InvalidArgumentException(
                    'Error: Expected AbstractNode, but got "'.gettype($childNode).'"'
                );
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
     * child nodes. This might sound strange but is possible.
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

    /**
     * @inheritdoc
     */
    public function traverse(Closure $callback, $level = 0)
    {
        $callback($this, $level);

        foreach ($this->childNodes as $childNode) {
            $childNode->traverse($callback, $level + 1);
        }
    }

}