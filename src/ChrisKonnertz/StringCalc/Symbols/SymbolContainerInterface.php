<?php

namespace ChrisKonnertz\StringCalc\Symbols;

/**
 * This is an interface for the SymbolContainer class.
 *
 * @package ChrisKonnertz\StringCalc
 */
interface SymbolContainerInterface
{

    /**
     * Adds a symbol to the array of symbols.
     *
     * @param AbstractSymbol $symbol        The new symbol object
     * @param string|null    $replaceSymbol Class name of an known symbol that you want to replace
     * @return void
     */
    public function addSymbol(AbstractSymbol $symbol, $replaceSymbol = null);

    /**
     * Removes a symbol from the array of symbols.
     * It is recommended to only remove custom symbols
     * (that have been added via the addSymbol() method)
     *
     * @param AbstractSymbol $symbol
     * @return void
     */
    public function removeSymbol(AbstractSymbol $symbol);

    /**
     * Returns the number of managed symbols.
     *
     * @return int
     */
    public function size();

    /**
     * Getter for the array of symbols.
     *
     * @return AbstractSymbol[]
     */
    public function getSymbols();

}