<?php

namespace ChrisKonnertz\StringCalc\Symbols;

use ChrisKonnertz\StringCalc\Exceptions\InvalidIdentifierException;
use ChrisKonnertz\StringCalc\Support\StringHelperInterface;

/**
 * A term is built of symbols: numbers/constants, variables, brackets, operators and functions.
 * - This is the abstract base class of all symbols.
 * - It is extended by a limited number of abstract classes that represent the different
 * types of symbols. These classes have an immutable semantic meaning.
 * - These classes may have child classes that are abstract as well, but are finally extended
 * by concrete classes that represent concrete symbols
 */
abstract class AbstractSymbol
{

    /**
     * Array with the 1-n (exception: the Numbers class may have 0)
     * unique identifiers (the textual representation of a symbol)
     * of the symbol. Example: ['/', ':']
     * Attention: The identifiers are case-sensitive, however,
     * valid identifiers in a term are always written in lower-case.
     * Therefore identifiers always have to be written in lower-case!
     *
     * @var string[]
     */
    protected $identifiers = [];

    /**
     * Subclasses can set their identifiers in $this->identifiers.
     * These identifiers need to be validated. This wil be done
     * in getIdentifiers(). Since we do not need to validate them
     * each time the getter is called we set a flag if we have
     * validated them once.
     *
     * @var bool
     */
    private $validatedIdentifiers = false;

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

        if (in_array($identifier, $this->identifiers)) {
            throw new InvalidIdentifierException('Error: Cannot add the identifier "'.$identifier.'" twice');
        }

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
    final public function validateIdentifier($identifier)
    {
        $this->stringHelper->validate($identifier);

        if (strpos($identifier, '.') !== false) {
            throw new InvalidIdentifierException('Error: Identifier cannot contain period characters');
        }

        // Use regular expression to search for characters that are digits
        // Regex is true when there are  0-n non-digits chars and then one digit
        // (it does not matter what is behind the digit)
        if (preg_match('/(\D*)\d/', $identifier) === 1) {
            throw new InvalidIdentifierException('Error: Identifier cannot contain any digits');
        }

        $this->validateIdentifierMore($identifier);
    }

    /**
     * Validate the identifier even more than with validateIdentifier().
     * This method is meant to be overwritten by the abstract subclasses
     * (such as AbstractOperator) if they need specialised validation.
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
     * Getter for the identifiers of the symbol.
     * Attention: The identifiers will be lower-cased!
     *
     * @return string[]
     */
    final public function getIdentifiers()
    {
        // Lower-case all identifiers to make it easier to find duplicate identifiers
        $identifiers = array_map('strtolower', $this->identifiers);

        if (! $this->validatedIdentifiers) {
            foreach ($identifiers as $identifier) {
                $this->validateIdentifier($identifier);
            }

            if (sizeof(array_unique($identifiers)) != sizeof($identifiers)) {
                throw new \DomainException('Error: Identifier duplicate found');
            }

            $this->validatedIdentifiers = true;
        }

        return $identifiers;
    }

}