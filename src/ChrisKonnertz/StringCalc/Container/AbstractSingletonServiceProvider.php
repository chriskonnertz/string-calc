<?php

namespace ChrisKonnertz\StringCalc\Container;

/**
 * This class is the base class for all providers that mimic the singleton
 * pattern: They always return the same object. The concrete provider only
 * has to implement the createService() method.
 *
 * @package ChrisKonnertz\StringCalc\Container
 */
abstract class AbstractSingletonServiceProvider extends AbstractServiceProvider
{

    /**
     * The service object
     *
     * @var object
     */
    protected $service;

    /**
     * Provides the service.
     *
     * @return object
     */
    public function provide()
    {
        if ($this->service === null) {
            $this->service = $this->createService();
        }

        return $this->service;
    }

}