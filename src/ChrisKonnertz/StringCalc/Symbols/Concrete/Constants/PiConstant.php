<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Constants;

use ChrisKonnertz\StringCalc\Symbols\AbstractConstant;

/**
 * PHP M_PI constant
 * Value: 3.14...
 * @see http://php.net/manual/en/math.constants.php
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