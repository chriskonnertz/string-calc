<?php namespace ChrisKonnertz\StringCalc;

use ChrisKonnertz\StringCalc\Exceptions\NotFoundException;
use ChrisKonnertz\StringCalc\Container\Container;
use ChrisKonnertz\StringCalc\Container\ContainerInterface;
use ChrisKonnertz\StringCalc\Container\ServiceProviderRegistry;
use ChrisKonnertz\StringCalc\Support\StringHelperInterface;
use ChrisKonnertz\StringCalc\Tokenizer\InputStreamInterface;
use ChrisKonnertz\StringCalc\Tokenizer\Tokenizer;

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
     * Setter for the container
     *
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

}