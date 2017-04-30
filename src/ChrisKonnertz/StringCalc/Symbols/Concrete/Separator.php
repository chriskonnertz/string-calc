<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete;

use ChrisKonnertz\StringCalc\Symbols\AbstractSeparator;

/**
 * This class is a class that represents symbols of type "separator".
 * A separator separates the arguments of a (mathematical) function.
 * Most likely we will only need one concrete "separator" class.
 */
class Separator extends AbstractSeparator
{

    protected $identifiers = [','];

}