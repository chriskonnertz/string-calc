<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete;

use ChrisKonnertz\StringCalc\Symbols\AbstractOperand;

/**
 * The comma "operand" is not a typical mathematical operand
 * but is used to separate the arguments of a function.
 * Commas in a term are always interpreted as the identifier
 * of the comma operand.
 *
 * @package ChrisKonnertz\StringCalc\Symbols\Concrete
 */
class CommaOperand extends AbstractOperand
{

    /**
     * @inheritdoc
     */
    protected $identifiers = [','];

    /**
     * @inheritdoc
     */
    const PRECEDENCE = PHP_INT_MAX;

    /**
     * @inheritdoc
     */
    public function operate($leftNumber, $rightNumber)
    {
        // TODO FIXME implement this
        throw new \Exception('Error: Comma operator not yet implemented! TODO: Implement');

        return 0;
    }

}