<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Constants;

use ChrisKonnertz\StringCalc\Symbols\AbstractConstant;

/**
 * PHP M_LNPI constant
 * Value: 1.14...
 * @see http://php.net/manual/en/math.constants.php
 */
class LnPiConstant extends AbstractConstant
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['lnPi'];

    /**
     * @inheritdoc
     */
    protected $value = M_LNPI;

}