<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Constants;

use ChrisKonnertz\StringCalc\Symbols\AbstractConstant;

/**
 * PHP M_LN10 constant
 * Value: 2.30...
 * @see http://php.net/manual/en/math.constants.php
 */
class LnTenConstant extends AbstractConstant
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['lnTen'];

    /**
     * @inheritdoc
     */
    protected $value = M_LN10;

}