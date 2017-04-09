<?php

namespace ChrisKonnertz\StringCalc\Parser;

use ChrisKonnertz\StringCalc\Symbols\AbstractSymbol;
use ChrisKonnertz\StringCalc\Tokenizer\Token;

/**
 * A node is a node in the syntax tree.
 * Nodes are created by the parser.
 *
 * @package ChrisKonnertz\StringCalc\Parser
 */
class Node
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