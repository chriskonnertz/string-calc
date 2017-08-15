<?php

namespace ChrisKonnertz\StringCalc\Grammar\Expressions;

/**
 * Abstract base class for all expression classes
 *
 * @package ChrisKonnertz\StringCalc\Grammar\Expressions
 */
abstract class AbstractExpression
{

    /**
     * ATTENTION: Child classes have to overwrite this method with their own implementation!
     *
     * @throws \Exception
     */
    abstract public function __toString();
//    {
//        throw new \Exception('Error: Child class did not overwrite the __toString() method!');
    //}

}