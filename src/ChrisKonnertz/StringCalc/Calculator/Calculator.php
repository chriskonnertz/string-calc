<?php

namespace ChrisKonnertz\StringCalc\Calculator;

use ChrisKonnertz\StringCalc\Parser\AbstractNode;
use ChrisKonnertz\StringCalc\Parser\ContainerNode;
use ChrisKonnertz\StringCalc\Parser\FunctionNode;
use ChrisKonnertz\StringCalc\Parser\SymbolNode;
use ChrisKonnertz\StringCalc\Symbols\AbstractConstant;
use ChrisKonnertz\StringCalc\Symbols\AbstractNumber;
use ChrisKonnertz\StringCalc\Symbols\AbstractOperator;
use ChrisKonnertz\StringCalc\Symbols\AbstractSymbol;

/**
 * The calculator has one important method: calculate()
 * It takes a container node as input and returns the
 * numeric result of the calculation.
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
     * @param ContainerNode $containerNode
     * @return float|int
     * @throws \Exception
     */
    protected function calculateContainerNode(ContainerNode $containerNode)
    {
        if (is_a($containerNode, FunctionNode::class)) {
            throw new \InvalidArgumentException('Error: Expected container node but got a function node.');
        }

        $nodes = $containerNode->getChildNodes();

        $calculableTerm = [];

        // TODO Remove this code? (If so also remove ResultBag class)
        // Create the $calculableTerm array which is ready for calculation.
        foreach ($nodes as $node) {
            if (is_a($node, SymbolNode::class)) {
                /** @var SymbolNode $node */

                if (is_a($node->getSymbol(), AbstractOperator::class)) {
                    $calculableTerm[] = $node;
                } else {
                    $calculableTerm[] = new ResultBag($node);
                }
            } else {
                $calculableTerm[] = new ResultBag($node);
            }
        }

        $operatorNodes = $this->detectCalculationOrder($nodes);

        // Actually calculate the term
        foreach ($operatorNodes as $index => $operatorNode) {
            if ($operatorNode->isUnaryOperator()) {
                $rightOperand = $nodes[$index + 1];

                if (is_a($rightOperand, SymbolNode::class)) {
                    $rightNumber = $this->calculateSymbolNode($rightOperand);
                } else if (is_a($rightOperand, FunctionNode::class)) {
                    $rightNumber = $this->calculateFunctionNode($rightOperand);
                } else {
                    /** @var ContainerNode $leftNumber */
                    $rightNumber = $this->calculateContainerNode($rightOperand);
                }

                /** @var AbstractOperator $symbol */
                $symbol = $operatorNode->getSymbol();

                $result = $symbol->operate(null, $rightNumber);

                unset($nodes[$index + 1]);
                $nodes[$index] = $result;
            } else {
                $leftOperand = $nodes[$index - 1];

                if (is_a($leftOperand, SymbolNode::class)) {
                    $leftNumber = $this->calculateSymbolNode($leftOperand);
                } else if (is_a($leftOperand, FunctionNode::class)) {
                    $leftNumber = $this->calculateFunctionNode($leftOperand);
                } else {
                    /** @var ContainerNode $leftNumber */
                    $leftNumber = $this->calculateContainerNode($leftOperand);
                }

                $rightOperand = $nodes[$index + 1];

                if (is_a($rightOperand, SymbolNode::class)) {
                    $rightNumber = $this->calculateSymbolNode($rightOperand);
                } else if (is_a($rightOperand, FunctionNode::class)) {
                    $rightNumber = $this->calculateFunctionNode($rightOperand);
                } else {
                    /** @var ContainerNode $leftNumber */
                    $rightNumber = $this->calculateContainerNode($rightOperand);
                }

                /** @var AbstractOperator $symbol */
                $symbol = $operatorNode->getSymbol();

                $result = $symbol->operate($leftNumber, $rightNumber);

                unset($nodes[$index - 1]);
                unset($nodes[$index + 1]);
                $nodes[$index] = $result;
            }
        }

        // The only remaining element of the $nodes array contains the overall result
        return current($nodes);

        // TODO Attention: This method will have to deal with separator symbols.
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

        if (is_a($symbol, AbstractNumber::class)) {
            $number = $node->getToken()->getValue();

            // Convert string to int or float (depending on the type of the number)
            // Attention: The fractional part of a PHP float can only have a limited length.
            // If the number has a longer fractional part, it will be cut.
            $number = 0 + $number;
        } elseif (is_a($symbol, AbstractConstant::class)) {
            /** @var AbstractConstant $symbol */

            $number = $symbol->getValue();
        } else {
            throw new \LogicException('Error: Found symbol of unexpected type.');
        }

        return $number;
    }

    /**
     * Detected the calculation order of a given array of nodes.
     * Does only care for the precedence of operators.
     * Does not care for child nodes of container nodes.
     * Returns a new array with ordered symbol nodes.
     *
     * @param AbstractNode[] $nodes
     * @return SymbolNode[]
     */
    protected function detectCalculationOrder(array $nodes)
    {
        $operatorNodes = [];

        // Store all symbol nodes that have a symbol of type abstract operator in an array
        foreach ($nodes as $index => $node) {
            if (is_a($node, SymbolNode::class)) {
                if (is_a($node->getSymbol(), AbstractOperator::class)) {
                    $operatorNodes[$index] = $node;
                }
            }
        }

        // Using Quicksort to sort the operators according to their precedence. Keeps the indices.
        uasort($operatorNodes, function(SymbolNode $nodeOne, SymbolNode $nodeTwo)
        {
            // Precedence of node one
            $symbolOne = $nodeOne->getSymbol();
            $precedenceOne = 2;
            if ($nodeOne->isUnaryOperator()) {
                $precedenceOne = 3;
            }

            // Precedence of node two
            $symbolTwo = $nodeTwo->getSymbol();
            $precedenceTwo = 2;
            if ($nodeTwo->isUnaryOperator()) {
                $precedenceTwo = 3;
            }

            if ($precedenceOne == $precedenceTwo) {
                $precedenceOne = constant(get_class($symbolOne).'::PRECEDENCE');
                $precedenceTwo = constant(get_class($symbolTwo).'::PRECEDENCE');
            }

            if ($precedenceOne == $precedenceTwo) {
                return 0;
            }
            return ($precedenceOne < $precedenceTwo) ? 1 : -1;
        });

        return $operatorNodes;
    }

    /**
     * Orders nodes they way they are supposed to be calculated.
     * The parameter is passed by reference so there is no return value.
     *
     * @param AbstractNode[] $nodes
     * @return void
     *
     * @deprecated TODO Remove this method if it is obsolete
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

            if ($precedenceOne == $precedenceTwo and $precedenceOne >= 2) {
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