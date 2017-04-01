<?php

namespace ChrisKonnertz\StringCalc\Container;

interface ServiceProviderRegistryInterface
{

    /**
     * This method has to return an array with the class names of
     * all registered service providers. Service providers have to
     * inherit from the AbstractServiceProvider class.
     *
     * @return string[]
     */
    public function getServiceProviders();

}