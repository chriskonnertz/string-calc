<?php

namespace ChrisKonnertz\StringCalc\Symbols;

/**
 * This class is the class that represents symbols of type "number".
 * Numbers are completely handled by the tokenizer/parser so there is no need to
 * create more than one concrete, empty number class (named "Numbers").
 * If there is more than one class that inherits this class and
 * is added to the symbol container, an exception will be thrown.
 */
abstract class AbstractNumber extends AbstractSymbol
{

}