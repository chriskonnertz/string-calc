<?php

namespace ChrisKonnertz\StringCalc\Parser\Nodes;

use Closure;

/**
 * This is the abstract base class for all parser nodes.
 * It does not implement any properties or methods.
 *
 * @package ChrisKonnertz\StringCalc\Parser
 */
abstract class AbstractNode
{

    /**
     * Call this method - especially on the root node of a syntax tree -
     * if you want to traverse it and all of it child nodes, no matter
     * how deep they are nested in the tree. You only have to pass a closure,
     * you do not have to pass an argument for the level parameter.
     * The callback will have two argument: The first is the node
     * (an object of type AbstractNode) and the second is the level of
     * this node. Example:
     *
     * $node->traverse(function($node, $level)
     * {
     *     var_dump($node, $level);
     * });
     *
     * @param Closure $callback
     * @param int     $level
     * @return void
     */
    abstract public function traverse(Closure $callback, $level = 0);

    /**
     * @return string
     */
    public function __toString()
    {
        return get_class($this);
    }

}
