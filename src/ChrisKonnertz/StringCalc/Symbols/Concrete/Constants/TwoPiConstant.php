<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Constants;

use ChrisKonnertz\StringCalc\Symbols\AbstractConstant;

/**
 * PHP M_2_PI constant
 * Value: 0.63...
 * @see http://php.net/manual/en/math.constants.php
 */
class TwoPiConstant extends AbstractConstant
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['twoPi'];

    /**
     * @inheritdoc
     */
    protected $value = M_2_PI;

}