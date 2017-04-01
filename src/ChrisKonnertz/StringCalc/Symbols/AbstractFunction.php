<?php namespace ChrisKonnertz\StringCalc\Symbols;

/**
 * This class is the base class for all symbols that are of the type "function".
 * Typically the textual representation of a function consists of two or more letters.
 */
abstract class AbstractFunction extends Symbol
{

    /**
     * An integer >= 0 that specifies how many arguments the
     * self::execute() method excepts.
     * const int
     */
    const NUMBER_OF_ARGUMENTS = 0;

    /**
     * This method is called when the function is executed. A function can have 0-n arguments.
     * The concrete number is specified in self::NUMBER_OF_ARGUMENTS.
     * The $arguments array has exactly the number of expected arguments.
     * If the function is noted with a different number of parameters in the term,
     * an exception will be thrown and the function will not be called.
     * The items of the $arguments array will always be of type int or float. They will never be null.
     * They keys will be integers starting at 0 and representing the positions of the arguments
     * in ascending order.
     * Overwrite this method in the concrete operand class.
     * If this class does NOT return a value of type int or float,
     * an exception will be thrown.
     *
     * @param  (int|float)[] $arguments
     * @return int|float
     */
    abstract public function execute(array $arguments);

}