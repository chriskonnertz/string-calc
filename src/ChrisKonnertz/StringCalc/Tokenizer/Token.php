<?php

namespace ChrisKonnertz\StringCalc\Tokenizer;

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
     * Defines the type of a token.
     * Example token value of a token with this type:
     * 'abs'
     *
     * @const int
     */
    const TYPE_WORD = 0;

    /**
     * Defines the type of a token.
     * Example token value of a token with this type:
     * '123'
     *
     * @const int
     */
    const TYPE_NUMBER = 1;

    /**
     * Defines the type of a token.
     * Example token value of a token with this type:
     * '+'
     *
     * @const int
     */
    const TYPE_CHARACTER = 2;

    /**
     * The raw value of the token. Numbers are stored as string.
     *
     * @var string
     */
    protected $value = null;

    /**
     * The type of the token. One of these constants:
     * self::TYPE_WORD|self::TYPE_NUMBER|self::TYPE_CHARACTER
     *
     * @var int
     */
    protected $type;

    /**
     * Position of the token in the input stream.
     * It is stored as a debugging information.
     *
     * @var int
     */
    protected $position;

    /**
     * Token constructor. The position must be >= 0.
     *
     * @param string    $value
     * @param string    $type
     * @param int       $position
     */
    public function __construct($value, $type, $position)
    {
        if (! is_string($value)) {
            throw new \InvalidArgumentException(
                'Error: Argument "value" has to be of type string but is of type "'.gettype($value).'"'
            );
        }
        $this->value = $value;

        if (! in_array($type, $this->getAllTypes())) {
            throw new \InvalidArgumentException(
                'Error: Argument "type" does not have the value of a known token type'
            );
        }
        $this->type = $type;

        if (! is_int($position)) {
            throw new \InvalidArgumentException('Error: Argument "position" has to be of type int');
        }
        if ($position < 0) {
            throw new \InvalidArgumentException('Error: Value of parameter "position" has to be >= zero');
        }
        $this->position = $position;
    }

    /**
     * Returns an array that contains the values of all
     * possible types of token type constants:
     * self::TYPE_WORD|self::TYPE_NUMBER|self::TYPE_CHARACTER
     *
     * @return int[]
     */
    public function getAllTypes()
    {
        return [self::TYPE_WORD, self::TYPE_NUMBER, self::TYPE_CHARACTER];
    }

    /**
     * Getter for the value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Getter for the type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Getter for the position
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }

}