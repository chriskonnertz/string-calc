<?php

namespace ChrisKonnertz\StringCalc\Calculator;

use ChrisKonnertz\StringCalc\Parser\Nodes\AbstractNode;
use ChrisKonnertz\StringCalc\Parser\Nodes\ContainerNode;
use ChrisKonnertz\StringCalc\Parser\Nodes\FunctionNode;
use ChrisKonnertz\StringCalc\Parser\Nodes\SymbolNode;
use ChrisKonnertz\StringCalc\Symbols\AbstractConstant;
use ChrisKonnertz\StringCalc\Symbols\AbstractFunction;
use ChrisKonnertz\StringCalc\Symbols\AbstractNumber;
use ChrisKonnertz\StringCalc\Symbols\AbstractOperator;
use ChrisKonnertz\StringCalc\Symbols\AbstractSeparator;

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
     * It takes a parser node as input and returns the numeric
     * result of the calculation.
     *
     * @param AbstractNode $rootNode
     * @return float|int
     */
    public function calculate(AbstractNode $rootNode)
    {
        $result = $this->calculateNode($rootNode);

        return $result;
    }

    /**
     * Calculates the numeric value / result of a node of
     * any known and calculable type. (For example symbol
     * nodes with a symbol of type separator are not
     * calculable.)
     *
     * @param AbstractNode $node
     * @return float|int
     */
    protected function calculateNode(AbstractNode $node)
    {
        if (is_a($node, SymbolNode::class)) {
            /** @var SymbolNode $node */

            return $this->calculateSymbolNode($node);
        } elseif (is_a($node, FunctionNode::class)) {
            /** @var FunctionNode $node */

            return $this->calculateFunctionNode($node);
        } elseif (is_a($node, ContainerNode::class)) {
            /** @var ContainerNode $node */

            return $this->calculateContainerNode($node);
        } else {
            throw new \InvalidArgumentException('Error: Cannot calculate node of unknown type.');
        }
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

        $orderedOperatorNodes = $this->detectCalculationOrder($nodes);

        // Actually calculate the term. iterates over the ordered operators and
        // calculates them, then replace the parts of the operation by the result.
        foreach ($orderedOperatorNodes as $index => $operatorNode) {
            reset($nodes);
            while (key($nodes) !== $index) {
                $leftOperand = current($nodes);
                $leftOperandIndex = key($nodes);
                next($nodes);
            }

            $rightOperand = next($nodes);
            $rightOperandIndex = key($nodes);
            $rightNumber = is_numeric($rightOperand) ? $rightOperand : $this->calculateNode($rightOperand);

            /** @var AbstractOperator $symbol */
            $symbol = $operatorNode->getSymbol();

            if ($operatorNode->isUnaryOperator()) {
                $result = $symbol->operate(null, $rightNumber);

                // Replace the participating symbols of the operation by the result
                unset($nodes[$rightOperandIndex]);
                $nodes[$index] = $result;
            } else {
                $leftNumber = is_numeric($leftOperand) ? $leftOperand : $this->calculateNode($leftOperand);

                $result = $symbol->operate($leftNumber, $rightNumber);

                // Replace the participating symbols of the operation by the result
                unset($nodes[$leftOperandIndex]);
                unset($nodes[$rightOperandIndex]);
                $nodes[$index] = $result;
            }
        }

        // The only remaining element of the $nodes array contains the overall result
        $result = end($nodes);

        // If the $nodes array did not contain any operator (but only one node) than
        // the result of this node has to be calculated now
        if (! is_numeric($result)) {
            return $this->calculateNode($result);
        }

        return $result;
    }

    /**
     * Returns the numeric value of a function node.
     *
     * @param FunctionNode $functionNode
     * @return int|float
     */
    protected function calculateFunctionNode(FunctionNode $functionNode)
    {
        $nodes = $functionNode->getChildNodes();

        $arguments = [];
        $argumentChildNodes = [];

        foreach ($nodes as $node) {
            if (is_a($node, SymbolNode::class)) {
                /** @var SymbolNode $node */

                if (is_a($node->getSymbol(), AbstractSeparator::class)) {
                    $containerNode = new ContainerNode($argumentChildNodes);
                    $arguments[] = $this->calculateContainerNode($containerNode);
                    $argumentChildNodes = [];
                } else {
                    $argumentChildNodes[] = $node;
                }
            } else {
                $argumentChildNodes[] = $node;
            }
        }

        if (sizeof($argumentChildNodes) > 0) {
            $containerNode = new ContainerNode($argumentChildNodes);
            $arguments[] = $this->calculateContainerNode($containerNode);
        }

        /** @var AbstractFunction $symbol */
        $symbol = $functionNode->getSymbolNode()->getSymbol();

        $result = $symbol->execute($arguments);

        return $result;
    }

    /**
     * Returns the numeric value of a symbol node.
     * Attention: $node->symbol must not be of type AbstractOperator!
     *
     * @param SymbolNode $symbolNode
     * @return int|float
     */
    protected function calculateSymbolNode(SymbolNode $symbolNode)
    {
        $symbol = $symbolNode->getSymbol();

        if (is_a($symbol, AbstractNumber::class)) {
            $number = $symbolNode->getToken()->getValue();

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
            // First-level precedence of node one
            /** @var AbstractOperator $symbolOne */
            $symbolOne = $nodeOne->getSymbol();
            $precedenceOne = 2;
            if ($nodeOne->isUnaryOperator()) {
                $precedenceOne = 3;
            }

            // First-level precedence of node two
            /** @var AbstractOperator $symbolTwo */
            $symbolTwo = $nodeTwo->getSymbol();
            $precedenceTwo = 2;
            if ($nodeTwo->isUnaryOperator()) {
                $precedenceTwo = 3;
            }

            // If the first-level precedence is the same, compare the second-level precedence
            if ($precedenceOne == $precedenceTwo) {
                $precedenceOne = $symbolOne->getPrecedence();
                $precedenceTwo = $symbolTwo->getPrecedence();
            }

            if ($precedenceOne == $precedenceTwo) {
                return 0;
            }
            return ($precedenceOne < $precedenceTwo) ? 1 : -1;
        });

        return $operatorNodes;
    }

}