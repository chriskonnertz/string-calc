<?php

namespace ChrisKonnertz\StringCalc\Symbols;

use ChrisKonnertz\StringCalc\Exceptions\InvalidIdentifierException;

/**
 * This class is the base class for all symbols that are of the type "function".
 * Typically the textual representation of a function consists of two or more letters.
 */
abstract class AbstractFunction extends AbstractSymbol
{

    /**
     * This method is called when the function is executed. A function can have 0-n parameters.
     * The implementation of this method is responsible to validate the number of arguments.
     * The $arguments array contains these arguments. If the number of arguments is improper,
     * the method has to throw a Exceptions\NumberOfArgumentsException exception.
     * The items of the $arguments array will always be of type int or float. They will never be null.
     * They keys will be integers starting at 0 and representing the positions of the arguments
     * in ascending order.
     * Overwrite this method in the concrete operator class.
     * If this class does NOT return a value of type int or float,
     * an exception will be thrown.
     *
     * @param  (int|float)[] $arguments
     * @return int|float
     */
    abstract public function execute(array $arguments);

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