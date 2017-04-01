<?php namespace ChrisKonnertz\StringCalc\Symbols;

/**
 * PHP M_PI constant
 */
abstract class PiConstant extends Symbol
{

    protected $textualRepresentations = ['pi'];

    const VALUE = M_PI;

}