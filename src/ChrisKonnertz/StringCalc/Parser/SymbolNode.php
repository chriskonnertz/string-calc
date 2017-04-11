<?php

namespace ChrisKonnertz\StringCalc\Parser;

use ChrisKonnertz\StringCalc\Symbols\AbstractSymbol;
use ChrisKonnertz\StringCalc\Tokenizer\Token;

/**
 * A symbol node is a node in the syntax tree.
 * Leaf nodes do not have any child nodes
 * (parent nodes can have child nodes). A
 * symbol node represents a mathematical symbol.
 * Nodes are created by the parser.
 *
 * @package ChrisKonnertz\StringCalc\Parser
 */
class SymbolNode extends AbstractNode
{

    /**
     * The token of the node. It contains the value.
     *
     * @var Token
     */
    protected $token;

    /**
     * The symbol of the node. It defines the type of the node.
     *
     * @var AbstractSymbol
     */
    protected $symbol;

    public function __construct(Token $token, AbstractSymbol $symbol)
    {
        $this->token = $token;

        $this->symbol = $symbol;
    }

    /**
     * Getter for the token
     *
     * @return Token
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Getter for the symbol
     *
     * @return AbstractSymbol
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

}