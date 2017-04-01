<?php namespace ChrisKonnertz\StringCalc;

use ChrisKonnertz\StringCalc\Exceptions\NotFoundException;
use ChrisKonnertz\StringCalc\Services\Container;
use ChrisKonnertz\StringCalc\Services\ContainerInterface;
use ChrisKonnertz\StringCalc\Services\ServiceProviderRegistry;
use ChrisKonnertz\StringCalc\Tokenizer\Tokenizer;

class StringCalc
{

    /**
     * The current version number
     *
     * @const string
     */
    const VERSION = '0.0.2';

    /**
     * The service container
     *
     * @var ContainerInterface
     */
    protected $container = null;

    /**
     * @param string $term
     * @return float|int
     * @throws NotFoundException
     */
    public function calculate($term)
    {
        if ($this->container === null) {
            $serviceRegistry = new ServiceProviderRegistry();
            $this->container = new Container($serviceRegistry);
        }

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
        $inputStream = new InputStream($term, $this->stringHelper);

        $tokenizer = new Tokenizer($inputStream, $this->stringHelper);

        $tokens = $tokenizer->tokenize();

        return $tokens;
    }

    /**
     * Settern for the container
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

}