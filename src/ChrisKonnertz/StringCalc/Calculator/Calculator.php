<?php

namespace ChrisKonnertz\StringCalc\Calculator;

use ChrisKonnertz\StringCalc\Exceptions\CalculatorException;
use ChrisKonnertz\StringCalc\Exceptions\StringCalcException;
use ChrisKonnertz\StringCalc\Parser\Nodes\AbstractNode;
use ChrisKonnertz\StringCalc\Parser\Nodes\ContainerNode;
use ChrisKonnertz\StringCalc\Parser\Nodes\FunctionNode;
use ChrisKonnertz\StringCalc\Parser\Nodes\SymbolNode;
use ChrisKonnertz\StringCalc\Support\UtilityTrait;
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
class Calculator implements CalculatorInterface
{

    use UtilityTrait;

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
            throw new \InvalidArgumentException('Error: Cannot calculate node of unknown type "'.get_class($node).'"');
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
     * @throws StringCalcException
     */
    protected function calculateContainerNode(ContainerNode $containerNode)
    {
        if (is_a($containerNode, FunctionNode::class)) {
            throw new \InvalidArgumentException('Error: Expected container node but got a function node');
        }

        $nodes = $containerNode->getChildNodes();

        $orderedOperatorNodes = $this->detectCalculationOrder($nodes);

        // Actually calculate the term. Iterates over the ordered operators and
        // calculates them, then replaces the parts of the operation by the result.
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

        if (sizeof($nodes) == 0) {
            $this->throwException(
                CalculatorException::class, 'Error: Missing calculable subterm. Are there empty brackets?'
            );
        }

        if (sizeof($nodes) > 1) {
            $this->throwException(CalculatorException::class, 'Error: Missing operators between parts of the term.');
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
            $this->throwException(
                CalculatorException::class,
                'Error: Found symbol of unexpected type "'.get_class($symbol).'", expected number or constant',
                $symbolNode->getToken()->getPosition(),
                $symbolNode->getToken()->getValue()
            );
        }

        return $number;
    }

    /**
     * Detect the calculation order of a given array of nodes.
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

        // Using Quicksort algorithm to sort the operators according to their precedence. Keeps the indices.
        // Returning 1 means $nodeTwo before $nodeOne, returning -1 means $nodeOne before $nodeTwo.
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

            // If the second-level precedence is the same, we have to ensure that the sorting algorithm does
            // insert the node / token that is left in the term before the node / token that is right.
            // Therefore we cannot return 0 but compare the positions and return 1 / -1.
            if ($precedenceOne == $precedenceTwo) {
                return ($nodeOne->getToken()->getPosition() < $nodeTwo->getToken()->getPosition()) ? -1 : 1;
            }
            return ($precedenceOne < $precedenceTwo) ? 1 : -1;
        });

        return $operatorNodes;
    }

}
