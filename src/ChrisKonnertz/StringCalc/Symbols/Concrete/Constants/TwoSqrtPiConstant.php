<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Constants;

use ChrisKonnertz\StringCalc\Symbols\AbstractConstant;

/**
 * PHP M_2_SQRTPI constant
 * Value: 1.12...
 * @see http://php.net/manual/en/math.constants.php
 */
class TwoSqrtPiConstant extends AbstractConstant
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['twoSqrtPi'];

    /**
     * @inheritdoc
     */
    protected $value = M_2_SQRTPI;

}