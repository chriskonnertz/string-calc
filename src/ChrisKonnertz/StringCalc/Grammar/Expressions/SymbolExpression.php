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
        $this->setSymbolMame($symbolName);
    }

    /**
     * Setter for the symbol name
     *
     * @param string $symbolName
     */
    public function setSymbolMame($symbolName)
    {
        if (! is_string($symbolName)) {
            throw new \InvalidArgumentException('Error: Expected string but got '.gettype($symbolName));
        }
        if (trim($symbolName) === '') {
            throw new \InvalidArgumentException('Error: Expected name but got empty string ro white space');
        }

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