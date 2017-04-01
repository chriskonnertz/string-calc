<?php namespace ChrisKonnertz\StringCalc\Symbols;

use \Support\StringHelper;

/**
 * A term is built of symbols: numbers/constants, variables, brackets, operands and functions
 */
abstract class Symbol
{

    /**
     * Array with the textual representations (1-n) of the symbol. Example: ['/', ':']
     * The textual representations are case-insensitive.
     *
     * @var string[]
     */
    protected $textualRepresentations;

    /**
     * @var StringHelper
     */
    protected $stringHelper;

    /**
     * @param StringHelper $stringHelper
     */
    final public function __construct(StringHelper $stringHelper)
    {
        $this->stringHelper = $stringHelper;
    }

    /**
     * Create a textual representation for the symbol at runtime.
     * All characters are allowed except digits and '.'.
     *
     * @param string $textualRepresentation
     * @return void
     * @throws \Exception
     */
    public function addTextualRepresentation($textualRepresentation)
    {
        $this->stringHelper->validate($textualRepresentation);

        if (in_array($textualRepresentation, $this->textualRepresentations)) {
            throw new \Exception('Error: Cannot add a textual representation twice');
        }

        $this->textualRepresentations[] = $textualRepresentation;
    }

    /**
     * Getter for the textual representations of the symbol
     *
     * @return string[]
     */
    public function getTextualRepresentations()
    {
        return $this->textualRepresentations;
    }

}