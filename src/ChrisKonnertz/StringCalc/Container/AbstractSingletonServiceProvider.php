<?php

namespace ChrisKonnertz\StringCalc\Container;

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