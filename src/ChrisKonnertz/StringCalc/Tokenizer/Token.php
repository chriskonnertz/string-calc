<?php

namespace ChrisKonnertz\StringCalc\Tokenizer;

use ChrisKonnertz\StringCalc\Symbols\AbstractSymbol;

/**
 * The tokenizer splits a term into an array of tokens.
 * Tokens are the parts of a term or to be more precise
 * the mathematical symbols of a term.
 *
 * @package ChrisKonnertz\StringCalc\Tokenizer
 */
class Token
{

    /**
     * The identifier that was used in the term for this token.
     * Might be equal to the identifier.
     *
     * @var string
     */
    protected $identifier;

    /**
     * The symbol of the token. It defines the type of the token.
     *
     * @var AbstractSymbol
     */
    protected $symbol;

    /**
     * The value of the token. Might be equal to the identifier
     *
     * @var string|int|float
     */
    protected $value = null;

    /**
     * Token constructor.
     *
     * @param string            $identifier
     * @param string|int|float  $value
     * @param AbstractSymbol    $symbol
     */
    public function __construct($identifier, $value, AbstractSymbol $symbol)
    {
        $this->identifier = $identifier;

        $this->value = $value;

        $this->symbol = $symbol;
    }

    /**
     * Getter for the identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
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
     * Getter for the value
     *
     * @return string|int|float
     */
    public function getValue()
    {
        return $this->value;
    }

}