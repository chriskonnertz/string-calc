<?php namespace ChrisKonnertz\StringCalc;

use ChrisKonnertz\StringCalc\Exceptions\NotFoundException;
use ChrisKonnertz\StringCalc\Container\Container;
use ChrisKonnertz\StringCalc\Container\ContainerInterface;
use ChrisKonnertz\StringCalc\Container\ServiceProviderRegistry;
use ChrisKonnertz\StringCalc\Support\StringHelperInterface;
use ChrisKonnertz\StringCalc\Symbols\AbstractSymbol;
use ChrisKonnertz\StringCalc\Tokenizer\InputStreamInterface;
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
    const VERSION = '0.0.3';

    /**
     * The service container
     *
     * @var ContainerInterface
     */
    protected $container = null;

    /**
     * Manager that manages all symbols
     *
     * @var SymbolManagerInterface
     */
    protected $symbolManager;

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

        $this->symbolManager = $this->container->get('stringcalc_symbolmanager');
    }

    /**
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

        // TODO parse etc, return result...
    }

    /**
     * @param string $term
     * @return array
     */
    protected function tokenize($term)
    {
        /** @var StringHelperInterface $stringHelper */
        $stringHelper = $this->container->get('stringcalc_stringhelper');

        /** @var InputStreamInterface $inputStream */
        $inputStream = $this->container->get('stringcalc_inputstream');
        $inputStream->setInput($term);

        $tokenizer = new Tokenizer($inputStream, $stringHelper);

        $tokens = $tokenizer->tokenize();

        return $tokens;
    }

    /**
     * Adds a symbol to the list of symbols.
     * This is just a shortcut method. Call getSymbolManager() if you want to
     * call more methods directly on the symbol manager.
     *
     * @param AbstractSymbol $symbol        The new symbol object
     * @param string|null    $replaceSymbol Class name of an known symbol that you want to replace
     * @return void
     */
    public function addSymbol(AbstractSymbol $symbol, $replaceSymbol = null)
    {
        $this->symbolManager->addSymbol($symbol, $replaceSymbol);
    }

    /**
     * Getter for the symbol manager
     *
     * @return SymbolManagerInterface
     */
    public function getSymbolManager()
    {
        return $this->symbolManager;
    }

}