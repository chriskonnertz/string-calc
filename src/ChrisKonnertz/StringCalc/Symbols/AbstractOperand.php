<?php namespace ChrisKonnertz\StringCalc\Symbols;

/**
 * This class is the base class for all symbols that are of the type "(binary) operand".
 * The textual representation of an operand consists of a single char that is not a letter.
 * It is worth noting that a operand has the same power as a function with two parameters.
 * Operands are always binary. To mimic a unary operator you might want to create a function
 * that accepts one parameter.
 */
abstract class AbstractOperand extends Symbol
{

    /**
     * The operand precedence determines which operands to perform first
     * in order to evaluate a given term.
     * You are supposed to overwrite this constant in the concrete constant class.
     * Take a look at other operand classes to see the precedences of the other operands.
     * 0: default, > 0: higher, < 0: lower
     *
     * @const int
     */
    const PRECEDENCE = 0;

    /**
     * This method is called when the operand has to execute a binary operation on two numbers.
     * The arguments will always be of type int or float. They will never be null.
     * Overwrite this method in the concrete operand class.
     * If this class does NOT return a value of type int or float,
     * an exception will be thrown.
     *
     * @param  int|float $leftNumber  The number that stand left to the operand
     * @param  int|float $rightNumber The number that stands right to the operand
     * @return int|float
     */
    abstract public function operate($leftNumber, $rightNumber);

}