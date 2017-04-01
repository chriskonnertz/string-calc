<?php

namespace ChrisKonnertz\StringCalc\Container;

use ChrisKonnertz\StringCalc\Exceptions\ContainerException;

abstract class AbstractServiceProvider
{
    /**
     * The name of the service that pointed to this service provider.
     *
     * @var string
     */
    private $serviceName;

    /**
     * The service container
     *
     * @var ContainerInterface
     */
    private $container;

    /**
     * AbstractServiceProvider constructor.
     *
     * @param string             $serviceName
     * @param ContainerInterface $container
     */
    public function __construct($serviceName, ContainerInterface $container)
    {
        $this->serviceName = $serviceName;
        $this->container = $container;
    }

    /**
     * Creates the service object and returns it.
     * This method has to be implemented in the concrete service provider.
     *
     * @return object
     */
    abstract protected function createService();

    /**
     * Provides the service. This method is called by the service container.
     *
     * @return object
     */
    public function provide()
    {
        return $this->createService();
    }

    /**
     * @param $serviceName
     * @return mixed
     * @throws ContainerException
     */
    protected function getService($serviceName)
    {
        if ($serviceName === $this->serviceName) {
            throw new ContainerException('Error: Service provider cannot depend on provided service.');
        }

        return $this->container->get($serviceName);
    }

    /**
     * Getter for the service name
     *
     * @return string
     */
    public function getServiceName()
    {
        return $this->serviceName;
    }

}