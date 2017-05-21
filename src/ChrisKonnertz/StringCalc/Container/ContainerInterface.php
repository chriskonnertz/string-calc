<?php

namespace ChrisKonnertz\StringCalc\Container;

use ChrisKonnertz\StringCalc\Exceptions\ContainerException;
use ChrisKonnertz\StringCalc\Exceptions\NotFoundException;

/**
 * Describes the interface of a container that exposes methods to read its entries.
 * Source: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-11-container.md
 */
interface ContainerInterface
{

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @throws NotFoundException  No entry was found for **this** identifier.
     * @throws ContainerException Error while retrieving the entry.
     *
     * @return mixed Entry.
     */
    public function get($id);

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
     * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return bool
     */
    public function has($id);

}