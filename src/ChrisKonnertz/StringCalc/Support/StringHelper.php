<?php

namespace ChrisKonnertz\StringCalc\Support;

/**
 * This class contains some methods that help dealing with strings.
 */
class StringHelper implements StringHelperInterface
{

    /**
     * Returns true if a string contains any multibyte characters.
     *
     * @param string $str
     * @return bool
     * @throws \Exception
     */
    public function containsMultibyteChar($str)
    {
        if (! is_string($str)) {
            throw new \InvalidArgumentException(
                'Error: Variable must be of type string but is of type "'.gettype($str).'"'
            );
        }

        return (mb_strlen($str) != strlen($str));
    }

    /**
     * Validates a string:
     * - Not null
     * - Not empty
     * - Is a string
     * - Does not contain multibyte characters
     * Will throw an exception if the validation fails.
     *
     * @param mixed|null $str
     * @return void
     * @throws \Exception
     */
    public function validate($str)
    {
        if ($str === null) {
            throw new \InvalidArgumentException('Error: String must not be null');
        }
        if (! is_string($str)) {
            throw new \InvalidArgumentException(
                'Error: String must be of type string but is of type "'.gettype($str).'"'
            );
        }
        if ($str === '') {
            throw new \InvalidArgumentException('Error: String must not be empty');
        }
        if ($this->containsMultibyteChar($str)) {
            throw new \InvalidArgumentException('Error: String must not contain any multibyte characters');
        }
    }

}