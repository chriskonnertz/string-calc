<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Constants;

use ChrisKonnertz\StringCalc\Symbols\AbstractConstant;

/**
 * PHP M_SQRT1_2 constant
 * Value: 0.70...
 * @see http://php.net/manual/en/math.constants.php
 */
class SqrtOneTwoConstant extends AbstractConstant
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['sqrtOneTwo'];

    /**
     * @inheritdoc
     */
    protected $value = M_SQRT1_2;

}