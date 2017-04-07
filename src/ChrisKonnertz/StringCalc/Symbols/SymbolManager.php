<?php

namespace ChrisKonnertz\StringCalc\Symbols;

/**
 * The symbol manager manages an array with all symbol objects.
 *
 * @package ChrisKonnertz\StringCalc
 */
class SymbolManager implements SymbolManagerInterface
{

    /**
     * Array with all available symbols
     *
     * @var AbstractSymbol[]
     */
    protected $symbols;

    /**
     * SymbolManager constructor.
     */
    public function __construct()
    {
        $this->prepareSymbols();
    }

    /**
     * Retrieves the list of available symbol classes,
     * creates objects of these classes and stores them.
     *
     * @return void
     */
    protected function prepareSymbols()
    {
        $symbolRegistry = new SymbolRegistry();
        $symbolClassesNames = $symbolRegistry->getSymbols();

        foreach ($symbolClassesNames as $symbolClassName) {
            $symbol = new $symbolClassName();
            $this->symbols[$symbolClassName] = $symbol;
        }
    }

    /**
     * Adds a symbol to the array of symbols.
     *
     * @param AbstractSymbol $symbol        The new symbol object
     * @param string|null    $replaceSymbol Class name of an known symbol that you want to replace
     * @return void
     */
    public function addSymbol(AbstractSymbol $symbol, $replaceSymbol = null)
    {
        if ($replaceSymbol === null) {
            if (array_key_exists(get_class($symbol), $this->symbols)) {
                throw new \InvalidArgumentException(
                    'Error: Trying to replace a symbol without using $replaceClass parameter.'
                );
            }

            $this->symbols[] = $symbol;
        } else {
            if (! is_string($replaceSymbol)) {
                throw new \InvalidArgumentException('Error: $replaceClass has to be the name of a class.');
            }

            if (! array_key_exists($replaceSymbol, $this->symbols)) {
                throw new \InvalidArgumentException('Error: Cannot replace the specified class since it is not known.');
            }

            $this->symbols[$replaceSymbol] = $symbol;
        }
    }

    /**
     * Removes a symbol from the array of symbols.
     * It is recommended to only remove custom symbols
     * (that have been added via the addSymbol() method)
     *
     * @param AbstractSymbol $symbol
     * @return void
     */
    public function removeSymbol(AbstractSymbol $symbol)
    {
        if (! in_array($symbol, $this->symbols)) {
            throw new \InvalidArgumentException('Error: Cannot remove symbol, because it is unknown.');
        }

        unset($this->symbols[get_class($symbol)]);
    }

    /**
     * Returns the number of managed symbols.
     *
     * @return int
     */
    public function size()
    {
        return sizeof($this->symbols);
    }

    /**
     * Getter for the array of symbols.
     *
     * @return AbstractSymbol[]
     */
    public function getSymbols()
    {
        return $this->symbols;
    }

}