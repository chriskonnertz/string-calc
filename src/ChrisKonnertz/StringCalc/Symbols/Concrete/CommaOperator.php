<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete;

use ChrisKonnertz\StringCalc\Symbols\AbstractOperator;

/**
 * The comma "operator" is not a typical mathematical operator
 * but is used to separate the arguments of a function.
 * Commas in a term are always interpreted as the identifier
 * of the comma operator.
 *
 * @package ChrisKonnertz\StringCalc\Symbols\Concrete
 */
class CommaOperator extends AbstractOperator
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