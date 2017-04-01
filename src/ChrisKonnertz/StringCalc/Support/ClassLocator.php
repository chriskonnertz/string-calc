<?php

namespace ChrisKonnertz\StringCalc\Config;

use ChrisKonnertz\StringCalc\Support\StringHelper;
use ChrisKonnertz\StringCalc\Tokenizer\InputStream;
use ChrisKonnertz\StringCalc\Tokenizer\Tokenizer;

class ClassLocator
{

    /**
     * Array that defines services.
     *
     * @var Service[]
     */
    protected $services = [
        'stringHelper' => StringHelper::class,
        'inputStream' => InputStream::class,
        'tokenizer' => Tokenizer::class,
    ];

    public function addService()
    {

    }

}