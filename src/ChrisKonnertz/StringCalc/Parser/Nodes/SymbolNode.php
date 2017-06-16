<?php

namespace ChrisKonnertz\StringCalc\Parser\Nodes;

use ChrisKonnertz\StringCalc\Symbols\AbstractOperator;
use ChrisKonnertz\StringCalc\Symbols\AbstractSymbol;
use ChrisKonnertz\StringCalc\Tokenizer\Token;
use Closure;

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

    /**
     * Unary operators need to be treated specially.
     * Therefore a node has to know if it (or to be
     * more precise the symbol of the node)
     * represents a unary operator.
     *
     * @var bool
     */
    protected $isUnaryOperator = false;

    /**
     * SymbolNode constructor.
     *
     * @param Token          $token
     * @param AbstractSymbol $symbol
     */
    public function __construct(Token $token, AbstractSymbol $symbol)
    {
        $this->token = $token;

        $this->symbol = $symbol;
    }

    /**
     * Setter for the token
     *
     * @param Token $token
     */
    public function setToken(Token $token)
    {
        $this->token = $token;
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
     * Setter for the symbol
     *
     * @param AbstractSymbol $symbol
     */
    public function setSymbol(AbstractSymbol $symbol)
    {
        $this->symbol = $symbol;
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

    /**
     * Setter to remember that the node (or to be more precise the
     * symbol of the node) represents a unary operator
     *
     * @param bool $isUnaryOperator
     */
    public function setIsUnaryOperator($isUnaryOperator = true)
    {
        if (! is_a($this->getSymbol(), AbstractOperator::class)) {
            throw new \InvalidArgumentException(
                'Error: Cannot mark node as unary operator, because symbol is not an operator but of type "'.
                gettype($this->getSymbol()).'"'
            );
        }

        $this->isUnaryOperator = $isUnaryOperator;
    }

    /**
     * Returns true if the node (or to be more precise the
     * symbol of the node) represents a unary operator
     *
     * @return bool
     */
    public function isUnaryOperator()
    {
        return $this->isUnaryOperator;
    }

    /**
     * @inheritdoc
     */
    public function traverse(Closure $callback, $level = 0)
    {
        $callback($this, $level);
    }

}