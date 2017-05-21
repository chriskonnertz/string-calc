<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Constants;

use ChrisKonnertz\StringCalc\Symbols\AbstractConstant;

/**
 * PHP M_SQRT3 constant
 * Value: 1.73...
 * @see http://php.net/manual/en/math.constants.php
 */
class SqrtThreeConstant extends AbstractConstant
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['sqrtThree'];

    /**
     * @inheritdoc
     */
    protected $value = M_SQRT3;

}