<?php namespace ChrisKonnertz\StringCalc;

use ChrisKonnertz\StringCalc\Support\StringHelper;
use ChrisKonnertz\StringCalc\Tokenizer\Tokenizer;
use ChrisKonnertz\StringCalc\Tokenizer\InputStream;

class StringCalc
{

    /**
     * The current version number
     *
     * @const string
     */
    const VERSION = '0.0.1';

    /**
     * @var StringHelper
     */
    protected $stringHelper;

    /**
     * @param DependencyContainer $dependencyContainer
     */
    final public function __construct(DependencyContainer $dependencyContainer)
    {
        $this->stringHelper = new StringHelper();
    }

    /**
     * @param string $term
     * @return int|float
     */
    public function calculate($term)
    {
        $this->stringHelper->validate($term);

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

}