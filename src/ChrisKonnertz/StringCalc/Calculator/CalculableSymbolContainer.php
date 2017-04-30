<?php

namespace ChrisKonnertz\StringCalc\Calculator;

use ChrisKonnertz\StringCalc\Parser\Nodes\AbstractNode;

class CalculableSymbolContainer
{

    /**
     * @var array
     */
    protected $rootSymbol;

    /**
     * @var CalculableSymbol
     */
    protected $currentSymbol;

    /**
     * CalculableSymbolContainer constructor.
     *
     * @param CalculableSymbol[] $calculableSymbols
     */
    public function __construct(array $calculableSymbols = array())
    {
        $this->setCalculabeSymbols($calculableSymbols);
    }

    /**
     * Setter for the position property.
     *
     * @param AbstractNode $calculableSymbols
     */
    public function setCalculableSymbols(array $calculableSymbols = array())
    {
        $this->currentSymbol = null;

        foreach ($calculableSymbols) {

        }
    }

    /**
     * Getter for the position property.
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Setter for the position property.
     *
     * @param int $position
     */
    public function setPosition($position)
    {
        if (! is_int($position)) {
            throw new \InvalidArgumentException('Error: Argument position is not of type int.');
        }
        if ($position < 0 or $position > $this->size() - 1) {
            throw new \InvalidArgumentException('Error: Argument position is out of range.');
        }

        $this->position = $position;
    }

    /**
     * Setter for the position property.
     *
     * @param AbstractNode $node
     */
    public function setPositionByNode(AbstractNode $node)
    {



    }

}