<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Constants;

use ChrisKonnertz\StringCalc\Symbols\AbstractConstant;

/**
 * PHP M_LOG10E constant
 * Value: 0.43...
 * @see http://php.net/manual/en/math.constants.php
 */
class LogTenEConstant extends AbstractConstant
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['logTenE'];

    /**
     * @inheritdoc
     */
    protected $value = M_LOG10E;

}