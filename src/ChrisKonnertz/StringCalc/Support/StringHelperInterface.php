<?php

namespace ChrisKonnertz\StringCalc\Support;

/**
 * A class that implements this interface has to contain methods that help dealing with strings.
 */
interface StringHelperInterface
{

    /**
     * Returns true if a string contains any multibyte characters.
     *
     * @param string $str
     * @return bool
     * @throws \Exception
     */
    public function containsMultibyteChar($str);

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
    public function validate($str);

}