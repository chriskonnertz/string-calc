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
     * Attention: The identifiers are case-sensitive, however,
     * valid identifiers in a term are always written in lower-case.
     * Therefore identifiers always have to be written in lower-case!
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
     * @throws InvalidIdentifierException
     */
    public function __construct(StringHelperInterface $stringHelper)
    {
        $this->stringHelper = $stringHelper;

        foreach ($this->identifiers as $identifier) {
            $this->validateIdentifier($identifier);
        }
    }

    /**
     * Create a new identifier for the symbol at runtime. All characters
     * are allowed except digits and '.'.
     *
     * @param string $identifier
     * @return void
     * @throws InvalidIdentifierException
     */
    public function addIdentifier($identifier)
    {
        $this->validateIdentifier($identifier);

        $this->identifiers[] = $identifier;
    }

    /**
     * Validate a given identifier. Throws an exception if the identifier
     * is invalid.
     * This method is declared as final, because the validation that is
     * done here is essential and the risk of its integrity being
     * corrupted by a subclass is too high.
     *
     * @param string $identifier
     * @return void
     * @throws InvalidIdentifierException
     */
    final protected function validateIdentifier($identifier)
    {
        $this->stringHelper->validate($identifier);

        if (strpos($identifier, '.') !== false) {
            throw new InvalidIdentifierException('Error: Identifier cannot contain period character');
        }

        // Use regular expression to search for digits
        if (preg_match('/[^0-9]/', $identifier) === 1) {
            throw new InvalidIdentifierException('Error: Identifier cannot contain any digits.');
        }

        // Ensure identifiers are written in lower-case.
        foreach ($this->identifiers as $identifier) {
            if (strtolower($identifier) !== $identifier) {
                throw new InvalidIdentifierException('Error: Identifier is not written in lower-case.');
            }
        }

        if (in_array($identifier, $this->identifiers)) {
            throw new InvalidIdentifierException('Error: Cannot add an identifier twice');
        }

        $this->validateIdentifier($identifier);
    }

    /**
     * Validate the identifier even more than with validateIdentifier().
     * This method is meant to be overwritten by the abstract subclasses
     * (such as AbstractOperand) if they need specialised validation.
     *
     * @param string $identifier
     * @return void
     * @throws InvalidIdentifierException
     */
    protected function validateIdentifierMore($identifier)
    {
        // Implement this method in a subclass. If the validations fails,
        // throw an InvalidIdentifierException exception.
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