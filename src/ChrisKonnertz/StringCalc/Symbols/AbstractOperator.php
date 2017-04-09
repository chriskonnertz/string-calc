<?php

namespace ChrisKonnertz\StringCalc\Symbols;

/**
 * This class is the base class for all symbols that are of the type "(binary) operator".
 * The textual representation of an operator consists of a single char that is not a letter.
 * It is worth noting that a operator has the same power as a function with two parameters.
 * Operators are always binary. To mimic a unary operator you might want to create a function
 * that accepts one parameter.
 */
abstract class AbstractOperator extends AbstractSymbol
{

    /**
     * The operator precedence determines which operators to perform first
     * in order to evaluate a given term.
     * You are supposed to overwrite this constant in the concrete constant class.
     * Take a look at other operator classes to see the precedences of the other operators.
     * 0: default, > 0: higher, < 0: lower
     *
     * @const int
     */
    const PRECEDENCE = 0;

    /**
     * Usually operators are binary, they operate on two operands (numbers).
     * But some can operate on one operand (number).
     * Notice: Operators can be unary AND binary (but this is a rare case)
     */
    const OPERATES_UNARY = false;

    /**
     * Usually operators are binary, they operate on two operands (numbers).
     * Notice: Operators can be unary AND binary (but this is a rare case)
     */
    const OPERATES_BINARY = true;

    /**
     * This method is called when the operator has to execute a binary operation on two numbers.
     * The arguments will always be of type int or float. They will never be null.
     * Overwrite this method in the concrete operator class.
     * If this class does NOT return a value of type int or float,
     * an exception will be thrown.
     *
     * @param  int|float $leftNumber  The number that stand left to the operator
     * @param  int|float $rightNumber The number that stands right to the operator
     * @return int|float
     */
    abstract public function operate($leftNumber, $rightNumber);

}