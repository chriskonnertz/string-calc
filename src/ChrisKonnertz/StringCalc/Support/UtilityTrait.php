<?php

namespace ChrisKonnertz\StringCalc\Support;

use ChrisKonnertz\StringCalc\Exceptions\StringCalcException;

/**
 * This is a trait with helper methods.
 *
 * @package ChrisKonnertz\StringCalc\Support
 */
trait UtilityTrait
{

    /**
     * Helper method. Throws a (custom) exception that should inherit from StringCalcException.
     *
     * @param string        $type The class name of the exception
     * @param string        $message The message f the exception. Must not contain unfiltered user input!
     * @param int|null      $position The position of the problem in the term
     * @param string|null   $subject Additional data. ATTENTION: May contain unfiltered user input!
     * @throws \Exception
     */
    protected function throwException($type, $message, $position = null, $subject = null)
    {
        $exception = new $type($message);

        if ($exception instanceof StringCalcException) {
            if ($position !== null) {
                $exception->setPosition($position);
            }

            if ($subject !== null) {
                $exception->setSubject($subject);
            }
        }
        if (! $exception instanceof \Exception) {
            throw new StringCalcException(
                'Error: Invalid call of the throwException method. Expected exception but got "'.gettype($exception).'"'
            );
        }

        throw $exception;
    }

}
