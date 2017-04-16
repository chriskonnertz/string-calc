<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete;

use ChrisKonnertz\StringCalc\Symbols\AbstractConstant;

/**
 * PHP M_PI constant
 * Value: 3.14...
 */
class PiConstant extends AbstractConstant
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['pi'];

    /**
     * @inheritdoc
     */
    protected $value = M_PI;

}