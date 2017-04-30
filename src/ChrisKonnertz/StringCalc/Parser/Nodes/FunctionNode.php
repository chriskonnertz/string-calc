<?php

namespace ChrisKonnertz\StringCalc\Parser\Nodes;

/**
 * A function in a term consists of the name of the function
 * (the symbol of the function) and the brackets that follow
 * the name and everything that is in this brackets (the
 * arguments). A function node combines these two things.
 * It stores its symbol in the $symbolNode property and its
 * arguments in the $childNodes property which is inherited
 * from the ContainerNode class.
 *
 * @package ChrisKonnertz\StringCalc\Parser
 */
class FunctionNode extends ContainerNode
{

    /**
     * @var SymbolNode
     */
    protected $symbolNode;

    /**
     * ContainerNode constructor.
     * Attention: The constructor is differs from the constructor
     * of the parent class!
     *
     * @param AbstractNode[] $childNodes
     * @param SymbolNode     $symbolNode
     */
    public function __construct(array $childNodes, SymbolNode $symbolNode)
    {
        parent::__construct($childNodes);

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

}