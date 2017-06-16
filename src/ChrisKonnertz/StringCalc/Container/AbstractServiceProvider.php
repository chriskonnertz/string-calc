<?php

namespace ChrisKonnertz\StringCalc\Container;

use ChrisKonnertz\StringCalc\Exceptions\ContainerException;

/**
 * A service provider returns a service object. In particular it creates
 * the service object by caring for its dependencies.
 *
 * @package ChrisKonnertz\StringCalc\Container
 */
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
     * This method returns another service. This way the provider
     * can satisfy the dependencies of the service it wants to provide.
     * WARNING: The current implementation is vulnerable to cycles
     * (infinite loops)! TODO: Try to solve this issue.
     *
     * @param $serviceName
     * @return mixed
     * @throws ContainerException
     */
    protected function getService($serviceName)
    {
        if ($serviceName === $this->serviceName) {
            throw new ContainerException('Error: Service provider "'.$serviceName.'" cannot depend on itself');
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