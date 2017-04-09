<?php

namespace ChrisKonnertz\StringCalc\Symbols;

use ChrisKonnertz\StringCalc\Exceptions\InvalidIdentifierException;
use ChrisKonnertz\StringCalc\Support\StringHelperInterface;

/**
 * A term is built of symbols: numbers/constants, variables, brackets, operands and functions.
 * - This is the abstract base class of all symbols.
 * - It is extended by a limited number of abstract classes that represent the different
 * types of symbols
 * - These classes are then extended by concrete classes that represent concrete symbols
 */
abstract class AbstractSymbol
{

    /**
     * Array with the 1-n unique identifiers (the textual
     * representation of a symbol) of the symbol. Example: ['/', ':']
     * The identifiers are case-insensitive.
     *
     * @var string[]
     */
    protected $identifiers;

    /**
     * @var StringHelperInterface
     */
    protected $stringHelper;

    /**
     * AbstractSymbol constructor.
     *
     * @param StringHelperInterface $stringHelper
     */
    public function __construct(StringHelperInterface $stringHelper)
    {
        $this->stringHelper = $stringHelper;
    }

    /**
     * Validate the identifier. This method is meant to be overwritten by
     * the abstract subclasses (such as AbstractOperand) if they need
     * specialised validation.
     *
     * @param string $identifier
     * @return void
     * @throws InvalidIdentifierException
     */
    protected function validateIdentifier($identifier)
    {
        // Implement this method in a subclass. If the validations fails,
        // throw an InvalidIdentifierException exception.
    }

    /**
     * Create a new identifier for the symbol at runtime. All characters
     * are allowed except digits and '.'. This method is declared as final,
     * because the validation that is done here is essential and the risk
     * of its integrity being corrupted by a subclass is too high.
     *
     * @param string $identifier
     * @return void
     * @throws \Exception
     */
    final public function addIdentifier($identifier)
    {
        $this->stringHelper->validate($identifier);

        if (strpos($identifier, '.') !== false) {
            throw new InvalidIdentifierException('Error: Identifier cannot contain period character');
        }

        // Use regular expression to search for digits
        if (preg_match('/[^0-9]/', $identifier) === 1) {
            throw new InvalidIdentifierException('Error: Identifier cannot contain any digits.');
        }

        $this->validateIdentifier($identifier);

        if (in_array($identifier, $this->identifiers)) {
            throw new InvalidIdentifierException('Error: Cannot add an identifier twice');
        }

        $this->identifiers[] = $identifier;
    }

    /**
     * Getter for the identifiers of the symbol
     *
     * @return string[]
     */
    public function getIdentifiers()
    {
        return $this->identifiers;
    }

}