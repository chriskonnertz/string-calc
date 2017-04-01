<?php namespace ChrisKonnertz\StringCalc\Support;

/**
 * This class contains some methods that help dealing with strings.
 */
class StringHelper
{

    /**
     * Returns true if a string contains any multibyte characters.
     *
     * @param string $str
     */
    public function containsMultibyteChar($str)
    {
        if (! is_string($str)) {
            throw new \InvalidArgumentException('Error: Variable must be of type string.');
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
     * @param  mixed|null $str
     * @return void
     */
    public function validate($str)
    {
        if ($term === null) {
            throw new \InvalidArgumentException('Error: Variable must not be null.');
        }
        if (! is_string($term)) {
            throw new \InvalidArgumentException('Error: Variable must be of type string.');
        }
        if ($term === '') {
            throw new \InvalidArgumentException('Error: Variable must not be empty.');
        }
        if ($this->containsMultibyteChar($term)) {
            throw new \InvalidArgumentException('Error: Variable must not contain any multibyte characters.');
        }
    }

}