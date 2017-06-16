<?php

namespace ChrisKonnertz\StringCalc\Symbols;

use ChrisKonnertz\StringCalc\Exceptions\InvalidIdentifierException;

/**
 * This class is the base class for all symbols that are of the type "constant".
 * We recommend to use names as textual representations for this type of symbol.
 * Please take note of the fact that the precision of PHP float constants
 * (for example M_PI) is based on the "precision" directive in php.ini,
 * which defaults to 14.
 */
abstract class AbstractConstant extends AbstractSymbol
{

    /**
     * This is the value of the constant. We use 0 as an example here,
     * but you are supposed to overwrite this in the concrete constant class.
     * Usually mathematical constants are not integers, however,
     * you are allowed to use an integer in this context.
     *
     * @var int|float
     */
    protected $value = 0;

    /**
     * Getter for the value property.
     * Typically the value of the constant should be stored in $this->value.
     * However, in case you want to calculate the value at runtime,
     * feel free to overwrite this getter method.
     *
     * @return int|float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @inheritdoc
     */
    protected function validateIdentifierMore($identifier)
    {
        // Use regular expression to ensure the identifier consists only of letters
        if (preg_match('/^[a-zA-Z]+$/', $identifier) !== 1) {
            throw new InvalidIdentifierException('Error: Identifier must consist of letters');
        }
    }

}