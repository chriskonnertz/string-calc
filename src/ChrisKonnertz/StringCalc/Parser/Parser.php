<?php

namespace ChrisKonnertz\StringCalc\Parser;

use ChrisKonnertz\StringCalc\Exceptions\NotFoundException;
use ChrisKonnertz\StringCalc\Exceptions\ParserException;
use ChrisKonnertz\StringCalc\Symbols\AbstractClosingBracket;
use ChrisKonnertz\StringCalc\Symbols\AbstractFunction;
use ChrisKonnertz\StringCalc\Symbols\AbstractOpeningBracket;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Number;
use ChrisKonnertz\StringCalc\Symbols\SymbolContainer;
use ChrisKonnertz\StringCalc\Symbols\SymbolContainerInterface;
use ChrisKonnertz\StringCalc\Tokenizer\Token;

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

    /**
     * The symbol container with all possible symbols
     *
     * @var SymbolContainerInterface
     */
    protected $symbolContainer;

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
     * @return array
     */
    public function parse(array $tokens)
    {
        $nodes = $this->detectSymbols($tokens);

        $nodes = $this->createTree($nodes);

        // TODO implement missing stuff

        return $nodes;
    }

    /**
     * Creates nodes from tokens. Nodes belong to a particular symbol.
     *
     * @param Token[] $tokens
     * @return Node[]
     * @throws \Exception
     */
    protected function detectSymbols(array $tokens)
    {
        $nodes = [];

        $expectingOpeningBracket = false; // True if we expect an opening bracket (after a function name)
        $openBracketCounter = 0;

        foreach ($tokens as $token) {
            $type = $token->getType();

            if ($type == Token::TYPE_WORD) {
                $identifier = $token->getValue();
                $symbol = $this->symbolContainer->find($identifier);

                if ($symbol === null) {
                    throw new NotFoundException('Error: Detected unknown or invalid identifier.');
                }

                if (is_a($symbol, AbstractFunction::class)) {
                    $expectingOpeningBracket = true;
                }
            } elseif ($type == Token::TYPE_NUMBER) {
                // Notice: Numbers do not have an identifier
                $symbol = $this->symbolContainer->findSubtype(Number::class)[0];
            } else { // Type Token::TYPE_CHARACTER:
                $identifier = $token->getValue();
                $symbol = $this->symbolContainer->find($identifier);

                if ($symbol === null) {
                    throw new NotFoundException('Error: Detected unknown or invalid identifier.');
                }

                if (is_a($symbol, AbstractOpeningBracket::class)) {
                    $openBracketCounter++;
                }
                if (is_a($symbol, AbstractClosingBracket::class)) {
                    $openBracketCounter--;

                    // Make sure there are not too many closing brackets
                    if ($openBracketCounter < 0) {
                        throw new ParserException(
                            'Error: Found closing bracket that does not have an opening bracket.'
                        );
                    }
                }
            }

            // Make sure a function is not followed by a symbol that is not of type opening bracket
            if ($expectingOpeningBracket) {
                if (! is_a($symbol, AbstractOpeningBracket::class)) {
                    throw new ParserException(
                        'Error: Expected opening bracket (after a function) but got something else.'
                    );
                }

                $expectingOpeningBracket = false;
            }

            $node = new Node($token, $symbol);

            $nodes[] = $node;
        }

        // Make sure the term does not end with the name of a function but without an opening bracket
        if ($expectingOpeningBracket) {
            throw new ParserException(
                'Error: Expected opening bracket (after a function) but reached the end of the term.'
            );
        }

        // Make sure there are not too many opening brackets
        if ($openBracketCounter > 0) {
            throw new ParserException(
                'Error: There is at least one opening bracket that does not have a closing bracket.'
            );
        }

        return $nodes;
    }

    /**
     * Expects a flat array of nodes and (if possible) transforms
     * it to a tree of nodes.
     *
     * @param Node[] $nodes
     * @return array
     */
    protected function createTree(array $nodes)
    {
        $tree = $this->createTreeByBrackets($nodes);

        // TODO implement missing stuff

        return $tree;
    }

    /**
     * Expects a flat array of nodes and (if possible) transforms
     * it to a tree of nodes. Only cares for brackets.
     * Attention: Expects valid brackets!
     * Check the brackets before you call this method.
     *
     * @param Node[] $nodes
     * @return array
     * @throws ParserException
     */
    protected function createTreeByBrackets(array $nodes)
    {
        $tree = [];
        $nodesInBrackets = []; // Nodes inside level0-brackets
        $openBracketCounter = 0;

        foreach ($nodes as $index => $node) {
            if (! is_a($node, Node::class)) {
                throw new ParserException('Error: Expected node, got something else.');
            }

            if (is_a($node->getSymbol(), AbstractOpeningBracket::class)) {
                $openBracketCounter++;

                if ($openBracketCounter > 1) {
                    $nodesInBrackets[] = $node;
                }
            } elseif (is_a($node->getSymbol(), AbstractClosingBracket::class)) {
                $openBracketCounter--;

                // Found a closing bracket on level 0
                if ($openBracketCounter == 0) {
                    $subTree = $this->createTreeByBrackets($nodesInBrackets);

                    // Subtree can be empty for example if the term looks like this: "()"
                    if (sizeof($subTree) > 0) {
                        $tree[] = $subTree;
                    }
                } else {
                    $nodesInBrackets[] = $node;
                }
            } else {
                if ($openBracketCounter == 0) {
                    $tree[] = $node;
                } else {
                    $nodesInBrackets[] = $node;
                }
            }
        }

        return $tree;
    }

}