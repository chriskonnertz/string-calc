<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete;

use ChrisKonnertz\StringCalc\Symbols\AbstractNumber;

/**
 * This class is the class that represents symbols of type "number".
 * Numbers are completely handled by the tokenizer/parser so there is no need to
 * create more than this concrete, empty number class that does not specify
 * a textual representation of numbers (numbers always consist of digits
 * and may include a single dot).
 */
final class Number extends AbstractNumber
{

}