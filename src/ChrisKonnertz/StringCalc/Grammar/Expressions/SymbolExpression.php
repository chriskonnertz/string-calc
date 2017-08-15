<?php

namespace ChrisKonnertz\StringCalc\Grammar\Expressions;

/**
 * This class represents language symbols.
 *
 * @package ChrisKonnertz\StringCalc\Grammar\Expressions
 */
class SymbolExpression extends AbstractExpression
{

    /**
     * The name of the language symbol
     *
     * @var string
     */
    protected $symbolName;

    /**
     * SymbolExpression constructor.
     *
     * @param string $symbolName
     */
    public function __construct($symbolName)
    {
        $this->symbolName = $symbolName;
    }

    /**
     * Getter for the symbol name
     *
     * @return string
     */
    public function getSymbolName()
    {
        return $this->symbolName;
    }

    public function __toString()
    {
        return $this->getSymbolName();
    }

}