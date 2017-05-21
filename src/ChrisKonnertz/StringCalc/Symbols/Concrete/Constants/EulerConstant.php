<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Constants;

use ChrisKonnertz\StringCalc\Symbols\AbstractConstant;

/**
 * PHP M_EULER constant
 * Value: 0.57...
 * @see http://php.net/manual/en/math.constants.php
 */
class EulerConstant extends AbstractConstant
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['euler'];

    /**
     * @inheritdoc
     */
    protected $value = M_EULER;

}