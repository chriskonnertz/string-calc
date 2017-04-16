<?php

namespace ChrisKonnertz\StringCalc;

use ChrisKonnertz\StringCalc\Exceptions\NotFoundException;
use ChrisKonnertz\StringCalc\Container\Container;
use ChrisKonnertz\StringCalc\Container\ContainerInterface;
use ChrisKonnertz\StringCalc\Container\ServiceProviderRegistry;
use ChrisKonnertz\StringCalc\Parser\ContainerNode;
use ChrisKonnertz\StringCalc\Parser\Parser;
use ChrisKonnertz\StringCalc\Support\StringHelperInterface;
use ChrisKonnertz\StringCalc\Symbols\AbstractSymbol;
use ChrisKonnertz\StringCalc\Symbols\SymbolContainerInterface;
use ChrisKonnertz\StringCalc\Tokenizer\InputStreamInterface;
use ChrisKonnertz\StringCalc\Tokenizer\Token;
use ChrisKonnertz\StringCalc\Tokenizer\Tokenizer;

/**
 * This is the StringCalc base class. Call the calculate() method to calculate a term.
 *
 * @package ChrisKonnertz\StringCalc
 */
class StringCalc
{

    /**
     * The current version number
     *
     * @const string
     */
    const VERSION = '0.4.0';

    /**
     * The service container
     *
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Container that manages all symbols
     *
     * @var SymbolContainerInterface
     */
    protected $symbolContainer;

    /**
     * StringCalc constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct($container = null)
    {
        // Create a new container instance if $container is null,
        // or try to use the $container object.
        if ($container === null) {
            $serviceRegistry = new ServiceProviderRegistry();
            $this->container = new Container($serviceRegistry);
        } else {
            if (! is_object($container)) {
                throw new \InvalidArgumentException('Error: Passed container parameter is not an object.');
            }

            $interfaces = class_implements($container);
            if (! in_array(ContainerInterface::class, $interfaces)) {
                throw new \InvalidArgumentException('Error: Passed container does not implement ContainerInterface.');
            }

            $this->container = $container;
        }

        $this->symbolContainer = $this->container->get('stringcalc_symbolcontainer');
    }

    /**
     * Calculates a term and returns the result.
     * Will return 0 if there is nothing to calculate.
     *
     * @param string $term
     * @return float|int
     * @throws NotFoundException
     */
    public function calculate($term)
    {
        $stringHelper = $this->container->get('stringcalc_stringhelper');
        $stringHelper->validate($term);
        $term = strtolower($term);

        $tokens = $this->tokenize($term);
        if (sizeof($tokens) == 0) {
            return 0;
        }

        $rootNode = $this->parse($tokens);
        if ($rootNode->isEmpty()) {
            return 0;
        }

        $result = $this->calculateTree($rootNode);

        return $result;
    }

    /**
     * Tokenize the term. Returns an array with the tokens.
     *
     * @param string $term
     * @return array
     */
    protected function tokenize($term)
    {
        /** @var InputStreamInterface $inputStream */
        $inputStream = $this->container->get('stringcalc_inputstream');
        $inputStream->setInput($term);

        /** @var StringHelperInterface $stringHelper */
        $stringHelper = $this->container->get('stringcalc_stringhelper');

        // TODO use tokenizer service?
        $tokenizer = new Tokenizer($inputStream, $stringHelper);

        $tokens = $tokenizer->tokenize();

        return $tokens;
    }

    /**
     * Parses an array with tokens. Returns an array of nodes.
     *
     * @param Token[] $tokens
     * @return ContainerNode
     */
    protected function parse(array $tokens)
    {
        /** @var SymbolContainerInterface $symbolContainer */
        $symbolContainer = $this->container->get('stringcalc_symbolcontainer');

        // TODO use parser service?
        $parser = new Parser($symbolContainer);

        $rootNode = $parser->parse($tokens);

        return $rootNode;
    }

    /**
     * This method actually calculates the results of every sub-terms
     * in the syntax tree (which consists of nodes).
     * It can call itself recursively.
     *
     * @param ContainerNode $rootNode
     * @return int|float
     */
    protected function calculateTree(ContainerNode $rootNode)
    {
        $childNodes = $rootNode->getChildNodes();

        foreach ($childNodes as $childNode) {
            if (is_a($childNode, ContainerNode::class)) {
                /** @var ContainerNode $childNode */
                $result = $this->calculateTree($childNode);
            }

            // ...
        }

        throw new \Exception('Error: Not yet implemented.');

        // Attention: This method will have to deal with separator symbols.

        // TODO: Convert string that are numbers values to int/float.
        // Maybe this is not the right place to tdo this -> then move it to a better place

        // Convert string to int or float (depending on the type of the number)
        // Attention: The fractional part of a PHP float can only have a limited length.
        // If the number has a longer fractional part, it will be cut.
        $value = 0 + $value;

        // --------------------------------------------------------------------------------------
        // The following lines of code come from the obsolete parser method sortNodesByPrecedence()

        $operators = [];

        foreach ($nodes as $index => $node) {
            if (is_a($node, SymbolNode::class)) {
                /** @var $node SymbolNode */
                $symbol = $node->getSymbol();
                if (is_a($symbol, AbstractOperator::class)) {
                    $operators[] = $node;
                }
            } else {
                /** @var $node ContainerNode */
                $transformedChildNodes = $this->sortNodesByPrecedence($node->getChildNodes());
                $node->setChildNodes($transformedChildNodes);
            }
        }

        // Using Quicksort to sort the operators according to their precedence. Keeps the indices.
        uasort($operators, function(SymbolNode $nodeOne, SymbolNode $nodeTwo)
        {

            $symbolOne = $nodeOne->getSymbol();
            $precedenceOne = constant(get_class($symbolOne).'::PRECEDENCE');

            $symbolTwo = $nodeTwo->getSymbol();
            $precedenceTwo = constant(get_class($symbolTwo).'::PRECEDENCE');

            if ($precedenceOne == $precedenceTwo) {
                return 0;
            }
            return ($precedenceOne < $precedenceTwo) ? 1 : -1;
        });

        $transformedNodes = [];



        return $nodes;

        return 0;
    }

    /**
     * Adds a symbol to the list of symbols.
     * This is just a shortcut method. Call getSymbolContainer() if you want to
     * call more methods directly on the symbol container.
     *
     * @param AbstractSymbol $symbol        The new symbol object
     * @param string|null    $replaceSymbol Class name of an known symbol that you want to replace
     * @return void
     */
    public function addSymbol(AbstractSymbol $symbol, $replaceSymbol = null)
    {
        $this->symbolContainer->addSymbol($symbol, $replaceSymbol);
    }

    /**
     * Getter for the symbol container
     *
     * @return SymbolContainerInterface
     */
    public function getSymbolContainer()
    {
        return $this->symbolContainer;
    }

    /**
     * Getter for the service container
     *
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

}