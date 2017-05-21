<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Constants;

use ChrisKonnertz\StringCalc\Symbols\AbstractConstant;

/**
 * PHP M_PI_4 constant
 * Value: 0.78...
 * @see http://php.net/manual/en/math.constants.php
 */
class PiFourConstant extends AbstractConstant
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['piFour'];

    /**
     * @inheritdoc
     */
    protected $value = M_PI_4;

}