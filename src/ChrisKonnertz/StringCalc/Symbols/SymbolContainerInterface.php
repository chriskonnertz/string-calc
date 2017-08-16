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
    public function add(AbstractSymbol $symbol, $replaceSymbol = null);

    /**
     * Removes a symbol from the array of symbols.
     * It is recommended to only remove custom symbols
     * (that have been added via the addSymbol() method)
     *
     * @param AbstractSymbol $symbol
     * @return void
     */
    public function remove(AbstractSymbol $symbol);

    /**
     * Returns the symbol that has the given identifier.
     * Returns null if none is found.
     *
     * @param string $identifier
     * @return AbstractSymbol|null
     */
    public function find($identifier);

    /**
     * Returns all symbols that inherit from a given abstract
     * parent type (class): The parent type has to be an
     * AbstractSymbol.
     * Notice: The parent type name will not be validated!
     *
     * @param string $parentTypeName
     * @return AbstractSymbol[]
     */
    public function findSubtypes($parentTypeName);

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
    public function getAll();

}