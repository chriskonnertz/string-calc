<?php

namespace ChrisKonnertz\StringCalc;

use ChrisKonnertz\StringCalc\Calculator\Calculator;
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
 * This is the StringCalc base class. It is the API frontend of
 * the StringCalc library. Call its calculate() method to
 * calculate a mathematical term.
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
    const VERSION = '0.5.3';

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

        // TODO use parser service?
        $calculator = new Calculator();

        $result = $calculator->calculate($rootNode);

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