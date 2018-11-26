<?php

namespace ChrisKonnertz\StringCalc\Parser;

use ChrisKonnertz\StringCalc\Exceptions\NotFoundException;
use ChrisKonnertz\StringCalc\Exceptions\ParserException;
use ChrisKonnertz\StringCalc\Parser\Nodes\AbstractNode;
use ChrisKonnertz\StringCalc\Parser\Nodes\ContainerNode;
use ChrisKonnertz\StringCalc\Parser\Nodes\FunctionNode;
use ChrisKonnertz\StringCalc\Parser\Nodes\SymbolNode;
use ChrisKonnertz\StringCalc\Support\UtilityTrait;
use ChrisKonnertz\StringCalc\Symbols\AbstractClosingBracket;
use ChrisKonnertz\StringCalc\Symbols\AbstractFunction;
use ChrisKonnertz\StringCalc\Symbols\AbstractOpeningBracket;
use ChrisKonnertz\StringCalc\Symbols\AbstractOperator;
use ChrisKonnertz\StringCalc\Symbols\AbstractSeparator;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Number;
use ChrisKonnertz\StringCalc\Symbols\SymbolContainerInterface;
use ChrisKonnertz\StringCalc\Tokenizer\Token;
use Closure;

/**
 * The parsers has one important method: parse()
 * It takes an array of tokens as input and
 * returns an array of nodes as output.
 * These nodes are the syntax tree of the term.
 *
 * @package ChrisKonnertz\StringCalc\Parser
 */
class Parser
{

    use UtilityTrait;

    /**
     * The symbol container with all possible symbols
     *
     * @var SymbolContainerInterface
     */
    protected $symbolContainer;

    /**
     * Closure that is called at the end of the grammar checking
     *
     * @var Closure
     */
    protected $customGrammarChecker = null;

    /**
     * Parser constructor.
     *
     * @param SymbolContainerInterface $symbolContainer
     */
    public function __construct(SymbolContainerInterface $symbolContainer)
    {
        $this->symbolContainer = $symbolContainer;
    }

    /**
     * Parses an array with tokens. Returns an array of nodes.
     * These nodes define a syntax tree.
     *
     * @param Token[] $tokens
     * @return ContainerNode
     */
    public function parse(array $tokens)
    {
        $symbolNodes = $this->detectSymbols($tokens);

        $nodes = $this->createTreeByBrackets($symbolNodes);

        $nodes = $this->transformTreeByFunctions($nodes);

        $this->checkGrammar($nodes);

        // Wrap the nodes in an array node.
        $rootNode = new ContainerNode($nodes);

        return $rootNode;
    }

    /**
     * Creates a flat array of symbol nodes from tokens.
     *
     * @param Token[] $tokens
     * @return SymbolNode[]
     * @throws NotFoundException
     * @throws ParserException
     */
    protected function detectSymbols(array $tokens)
    {
        $symbolNodes = [];

        $expectingOpeningBracket = false; // True if we expect an opening bracket (after a function name)
        $openBracketCounter = 0;

        foreach ($tokens as $token) {
            $type = $token->getType();

            if ($type == Token::TYPE_WORD) {
                $identifier = $token->getValue();
                $symbol = $this->symbolContainer->find($identifier);

                if ($symbol === null) {
                    $this->throwException(
                        NotFoundException::class,
                        'Error: Detected unknown or invalid string identifier.',
                        $token->getPosition(),
                        $identifier
                    );
                }
            } elseif ($type == Token::TYPE_NUMBER) {
                // Notice: Numbers do not have an identifier
                $symbol = $this->symbolContainer->findSubtypes(Number::class)[0];
            } else { // Type Token::TYPE_CHARACTER:
                $identifier = $token->getValue();
                $symbol = $this->symbolContainer->find($identifier);

                if ($symbol === null) {
                    $this->throwException(
                        NotFoundException::class,
                        'Error: Detected unknown or invalid character identifier.',
                        $token->getPosition(),
                        $identifier
                    );
                }

                if (is_a($symbol, AbstractOpeningBracket::class)) {
                    $openBracketCounter++;
                }
                if (is_a($symbol, AbstractClosingBracket::class)) {
                    $openBracketCounter--;

                    // Make sure there are not too many closing brackets
                    if ($openBracketCounter < 0) {
                        $this->throwException(
                            ParserException::class,
                            'Error: Found closing bracket that does not have an opening bracket.',
                            $token->getPosition(),
                            $identifier
                        );
                    }
                }
            }

            // Make sure a function is not followed by a symbol that is not of type opening bracket
            if ($expectingOpeningBracket) {
                if (! is_a($symbol, AbstractOpeningBracket::class)) {
                    $this->throwException(
                        ParserException::class,
                        'Error: Expected opening bracket (after a function) but got something else.',
                        $token->getPosition(),
                        get_class($symbol)
                    );
                }

                $expectingOpeningBracket = false;
            } else {
                if (is_a($symbol, AbstractFunction::class)) {
                    $expectingOpeningBracket = true;
                }
            }

            $symbolNode = new SymbolNode($token, $symbol);

            $symbolNodes[] = $symbolNode;
        }

        // Make sure the term does not end with the name of a function but without an opening bracket
        if ($expectingOpeningBracket) {
            throw new ParserException(
                'Error: Expected opening bracket (after a function) but reached the end of the term'
            );
        }

        // Make sure there are not too many opening brackets
        if ($openBracketCounter > 0) {
            throw new ParserException(
                'Error: There is at least one opening bracket that does not have a closing bracket'
            );
        }

        return $symbolNodes;
    }

    /**
     * Expects a flat array of symbol nodes and (if possible) transforms
     * it to a tree of nodes. Cares for brackets.
     * Attention: Expects valid brackets!
     * Check the brackets before you call this method.
     *
     * @param SymbolNode[] $symbolNodes
     * @return AbstractNode[]
     * @throws ParserException
     */
    protected function createTreeByBrackets(array $symbolNodes)
    {
        $tree = [];
        $nodesInBrackets = []; // AbstractSymbol nodes inside level-0-brackets
        $openBracketCounter = 0;

        foreach ($symbolNodes as $index => $symbolNode) {
            if (! is_a($symbolNode, SymbolNode::class)) {
                throw new ParserException('Error: Expected symbol node, but got "'.gettype($symbolNode).'"');
            }

            if (is_a($symbolNode->getSymbol(), AbstractOpeningBracket::class)) {
                $openBracketCounter++;

                if ($openBracketCounter > 1) {
                    $nodesInBrackets[] = $symbolNode;
                }
            } elseif (is_a($symbolNode->getSymbol(), AbstractClosingBracket::class)) {
                $openBracketCounter--;

                // Found a closing bracket on level 0
                if ($openBracketCounter == 0) {
                    $subTree = $this->createTreeByBrackets($nodesInBrackets);

                    // Subtree can be empty for example if the term looks like this: "()" or "functioname()"
                    // But this is okay, we need to allow this so we can call functions without a parameter
                    $tree[] = new ContainerNode($subTree);
                    $nodesInBrackets = [];
                } else {
                    $nodesInBrackets[] = $symbolNode;
                }
            } else {
                if ($openBracketCounter == 0) {
                    $tree[] = $symbolNode;
                } else {
                    $nodesInBrackets[] = $symbolNode;
                }
            }
        }

        return $tree;
    }

    /**
     * Replaces [a SymbolNode that has a symbol of type AbstractFunction,
     * followed by a node of type ContainerNode] by a FunctionNode.
     * Expects the $nodes not including any function nodes (yet).
     *
     * @param AbstractNode[] $nodes
     * @return AbstractNode[]
     * @throws ParserException
     */
    protected function transformTreeByFunctions(array $nodes)
    {
        $transformedNodes = [];

        $functionSymbolNode = null;

        foreach ($nodes as $node) {
            if (is_a($node, ContainerNode::class)) {
                /** @var ContainerNode $node */
                $transformedChildNodes = $this->transformTreeByFunctions($node->getChildNodes());

                if ($functionSymbolNode !== null) {
                    $functionNode = new FunctionNode($transformedChildNodes, $functionSymbolNode);
                    $transformedNodes[] = $functionNode;
                    $functionSymbolNode = null;
                } else {
                    $node->setChildNodes($transformedChildNodes);
                    $transformedNodes[] = $node;
                }
            } elseif (is_a($node, SymbolNode::class)) {
                /** @var SymbolNode $node */
                $symbol = $node->getSymbol();
                if (is_a($symbol, AbstractFunction::class)) {
                    $functionSymbolNode = $node;
                } else {
                    $transformedNodes[] = $node;
                }
            } else {
                throw new ParserException('Error: Expected array node or symbol node, got "'.gettype($node).'"');
            }
        }

        return $transformedNodes;
    }

    /**
     * Ensures the tree follows the grammar rules for terms
     *
     * @param array $nodes
     * @return void
     * @throws ParserException
     */
    protected function checkGrammar(array $nodes)
    {
        // TODO Make sure that separators are only in the child nodes of the array node of a function node
        // (If this happens the calculator will throw an exception)

        foreach ($nodes as $index => $node) {
            if (is_a($node, SymbolNode::class)) {
                /** @var $node SymbolNode */

                $symbol = $node->getSymbol();

                if (is_a($symbol, AbstractOperator::class)) {
                    /** @var $symbol AbstractOperator */

                    $posOfRightOperand = $index + 1;

                    // Make sure the operator is positioned left of a (potential) operand (=prefix notation).
                    // Example term: "-1"
                    if ($posOfRightOperand >= sizeof($nodes)) {
                        $this->throwException(
                            ParserException::class,
                            'Error: Found operator that does not stand before an operand.',
                            $node->getToken()->getValue(),
                            $node->getToken()->getPosition()
                        );
                    }

                    $posOfLeftOperand = $index - 1;

                    $leftOperand = null;

                    // Operator is unary if positioned at the beginning of a term
                    if ($posOfLeftOperand >= 0) {
                        $leftOperand = $nodes[$posOfLeftOperand];

                        if (is_a($leftOperand, SymbolNode::class)) {
                            /** @var $leftOperand SymbolNode */
                            if (is_a($leftOperand->getSymbol(), AbstractOperator::class)
                                ||
                                is_a($leftOperand->getSymbol(), AbstractSeparator::class)
                            ) {
                                // Operator is unary if positioned right to another operator
                                $leftOperand = null;
                            }
                        }
                    }

                    // If null, the operator is unary
                    if ($leftOperand === null) {
                        if (! $symbol->getOperatesUnary()) {
                            $this->throwException(
                                ParserException::class,
                                'Error: Found operator in unary notation that is not unary.',
                                $node->getToken()->getValue(),
                                $node->getToken()->getPosition()
                            );
                        }

                        // Remember that this node represents a unary operator
                        $node->setIsUnaryOperator(true);
                    } else {
                        if (! $symbol->getOperatesBinary()) {
                            $this->throwException(
                                ParserException::class,
                                'Error: Found operator in binary notation that is not binary.',
                                $node->getToken()->getValue(),
                                $node->getToken()->getPosition()
                            );
                        }
                    }
                }
            } else {
                /** @var $node ContainerNode */
                $this->checkGrammar($node->getChildNodes());
            }
        }

        if ($this->customGrammarChecker !== null) {
            $customGrammarChecker = $this->customGrammarChecker;

            // Execute custom grammar checker function
            $customGrammarChecker($nodes);
        }
    }

    /**
     * Setter for the custom grammar checker property.
     * Expects a function (closure) as a parameter.
     * This function is called at the end of the
     * grammar checking. An array with all nodes is
     * passed as an argument. If grammar checking
     * fails, the function has to throw a ParserException.
     * @param Closure $customGrammarChecker
     */
    public function setCustomGrammarChecker(Closure $customGrammarChecker)
    {
        $this->customGrammarChecker = $customGrammarChecker;
    }

    /**
     * Removes the custom grammar checker.
     */
    public function unsetCustomGrammarChecker()
    {
        $this->customGrammarChecker = null;
    }

    /**
     * Getter for the custom grammar checker property.
     *
     * @return Closure
     */
    public function getCustomGrammarChecker()
    {
        return $this->customGrammarChecker;
    }

}
