<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Constants;

use ChrisKonnertz\StringCalc\Symbols\AbstractConstant;

/**
 * PHP M_1_PI constant
 * Value: 0.31...
 * @see http://php.net/manual/en/math.constants.php
 */
class OnePiConstant extends AbstractConstant
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['onePi'];

    /**
     * @inheritdoc
     */
    protected $value = M_1_PI;

}