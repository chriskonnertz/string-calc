<?php

namespace ChrisKonnertz\StringCalc\Calculator;

use ChrisKonnertz\StringCalc\Parser\AbstractNode;
use ChrisKonnertz\StringCalc\Parser\ContainerNode;
use ChrisKonnertz\StringCalc\Parser\FunctionNode;
use ChrisKonnertz\StringCalc\Parser\SymbolNode;
use ChrisKonnertz\StringCalc\Symbols\AbstractConstant;
use ChrisKonnertz\StringCalc\Symbols\AbstractNumber;
use ChrisKonnertz\StringCalc\Symbols\AbstractOperator;

/**
 * The parsers has one important method: calculate()
 * It takes a parser container node as input and
 * returns the numeric result of the calculation.
 *
 * @package ChrisKonnertz\StringCalc\Calculator
 */
class Calculator
{

    /**
     * Calculates the numeric result of nodes in the syntax tree.
     * It takes a parser container node as input and returns the
     * numeric result of the calculation.
     *
     * @param ContainerNode $rootNode
     * @return float|int
     */
    public function calculate(ContainerNode $rootNode)
    {
        $result = $this->calculateContainerNode($rootNode);

        return $result;
    }

    /**
     * This method actually calculates the results of every sub-terms
     * in the syntax tree (which consists of nodes).
     * It can call itself recursively.
     * Attention: $node must not be of type FunctionNode!
     *
     * @param ContainerNode $rootNode
     * @return float|int
     * @throws \Exception
     */
    protected function calculateContainerNode(ContainerNode $rootNode)
    {
        if (is_a($rootNode, FunctionNode::class)) {
            throw new \InvalidArgumentException('Error: Expected container node but got a function node.');
        }

        $nodes = $rootNode->getChildNodes();

        $this->orderNodes($nodes);

        foreach ($nodes as $key => $node) {
            if (is_a($node, SymbolNode::class)) {
                /** @var SymbolNode $node */

                $symbol = $node->getSymbol();

                if (is_a($symbol, AbstractOperator::class)) {
                    /** @var $symbol AbstractOperator */

                    if ($node->isUnaryOperator()) {
                        // TODO implement
                        //$result = $symbol->operate(null, $rightNumber);
                    } else {
                        $leftOperand = $nodes[$key -1];

                        if (is_a($leftOperand, SymbolNode::class)) {
                            $leftNumber = $this->calculateSymbolNode($leftOperand);
                        } else if (is_a($leftOperand, FunctionNode::class)) {
                            $leftNumber = $this->calculateFunctionNode($leftOperand);
                        } else {
                            /** @var ContainerNode $leftNumber */
                            $leftNumber = $this->calculateContainerNode($leftOperand);
                        }

                        $rightOperand = $nodes[$key -1];

                        if (is_a($rightOperand, SymbolNode::class)) {
                            $rightNumber = $this->calculateSymbolNode($rightOperand);
                        } else if (is_a($rightOperand, FunctionNode::class)) {
                            $rightNumber = $this->calculateFunctionNode($rightOperand);
                        } else {
                            /** @var ContainerNode $leftNumber */
                            $rightNumber = $this->calculateContainerNode($rightOperand);
                        }

                        $result = $symbol->operate($leftNumber, $rightNumber);
                        // TODO use result
                    }
                } else {
                    // All functions and operators have been calculated so leave the loop
                    break;
                }
            } elseif (is_a($node, FunctionNode::class)) {
                /** @var FunctionNode $node */

                $result = $this->calculateFunctionNode($node);
                // TODO use result
            } else {
                // All functions and operators have been calculated so leave the loop
                break;
            }
        }

        throw new \Exception('Error: Not yet implemented.');

        // Attention: This method will have to deal with separator symbols.

        return 0;
    }

    /**
     * @param FunctionNode $node
     * @return int|float
     */
    protected function calculateFunctionNode(FunctionNode $node)
    {
        // TODO implement

        return 0;
    }

    /**
     * Returns the numeric value of a symbol node.
     * Attention: $node->symbol must not be of type AbstractOperator!
     *
     * @param SymbolNode $node
     * @return int|float
     */
    protected function calculateSymbolNode(SymbolNode $node)
    {
        $symbol = $node->getSymbol();

        if (is_a($node, AbstractNumber::class)) {
            $number = $node->getToken()->getValue();

            // Convert string to int or float (depending on the type of the number)
            // Attention: The fractional part of a PHP float can only have a limited length.
            // If the number has a longer fractional part, it will be cut.
            $number = 0 + $number;
        } elseif (is_a($node, AbstractConstant::class)) {
            /** @var AbstractConstant $symbol */

            $number = $symbol->getValue();
        } else {
            // TODO Do we need this exception?
            throw new \LogicException('Error: Found symbol of unexpected type.');
        }

        return $number;
    }

    /**
     * Orders nodes they way they are supposed to be calculated.
     * The parameter is passed by reference so there is no return value.
     *
     * @param AbstractNode[] $nodes
     * @return void
     */
    protected function orderNodes(array &$nodes)
    {
        // Using Quicksort to sort the symbols according to their precedence. Keeps the indices.
        uasort($nodes, function(AbstractNode $nodeOne, AbstractNode $nodeTwo)
        {
            $precedenceOne = 0;
            if (is_a($nodeOne, FunctionNode::class)) {
                $precedenceOne = 1;
            }
            if (is_a($nodeOne, SymbolNode::class)) {
                /** @var SymbolNode $nodeOne */

                $symbolOne = $nodeOne->getSymbol();

                if (is_a($symbolOne, AbstractOperator::class)) {
                    $precedenceOne = 2;

                    if ($nodeOne->isUnaryOperator()) {
                        $precedenceOne = 3;
                    }
                }
            }

            $precedenceTwo = 0;
            if (is_a($nodeTwo, FunctionNode::class)) {
                $precedenceTwo = 1;
            }
            if (is_a($nodeTwo, SymbolNode::class)) {
                /** @var SymbolNode $nodeTwo */
                $symbolTwo = $nodeTwo->getSymbol();

                if (is_a($symbolTwo, AbstractOperator::class)) {
                    $precedenceTwo = 2;

                    if ($nodeTwo->isUnaryOperator()) {
                        $precedenceTwo = 3;
                    }
                }
            }

            if ($precedenceOne == $precedenceTwo and $precedenceOne > 2) {
                $precedenceOne = constant(get_class($symbolOne).'::PRECEDENCE');
                $precedenceTwo = constant(get_class($symbolTwo).'::PRECEDENCE');
            }

            if ($precedenceOne == $precedenceTwo) {
                return 0;
            }
            return ($precedenceOne < $precedenceTwo) ? 1 : -1;
        });
    }

}