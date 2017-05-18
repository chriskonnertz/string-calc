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
     * @param Closure $callback
     * @param int     $level
     * @return void
     */
    abstract public function traverse(Closure $callback, $level = 0);

}