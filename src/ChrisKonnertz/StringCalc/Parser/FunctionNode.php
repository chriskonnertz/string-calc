<?php

namespace ChrisKonnertz\StringCalc\Parser;

class FunctionNode extends AbstractNode
{

    /**
     * @var SymbolNode
     */
    protected $symbolNode;

    /**
     * @var ArrayNode
     */
    protected $arrayNode;

    /**
     * FunctionNode constructor.
     *
     * @param SymbolNode $symbolNode
     */
    public function __construct(SymbolNode $symbolNode)
    {
        $this->symbolNode = $symbolNode;
    }

    /**
     * @return SymbolNode
     */
    public function getSymbolNode()
    {
        return $this->symbolNode;
    }

    /**
     * @param SymbolNode $symbolNode
     */
    public function setSymbolNode(SymbolNode $symbolNode)
    {
        $this->symbolNode = $symbolNode;
    }

    /**
     * @return ArrayNode
     */
    public function getArrayNode()
    {
        return $this->arrayNode;
    }

    /**
     * @param ArrayNode $arrayNode
     */
    public function setArrayNode(ArrayNode $arrayNode)
    {
        $this->arrayNode = $arrayNode;
    }

}