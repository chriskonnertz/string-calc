<?php

namespace ChrisKonnertz\StringCalc\Tokenizer;

interface InputStreamInterface
{

    /**
     * Move the pointer to the next position.
     * Will always move the pointer, even if the end of the term has been passed.
     *
     * @return string|null
     */
    public function readNext();

    /**
     * Returns the current character.
     *
     * @return string|null
     */
    public function readCurrent();

    /**
     * Returns true if there is a character at the current position
     *
     * @return bool
     */
    public function hasCurrent();

    /**
     * Resets the cursor to the beginning of the string.
     *
     * @return void
     */
    public function reset();

    /**
     * Setter for the input string
     *
     * @param string $input
     */
    public function setInput($input);

    /**
     * Getter for the input string
     *
     * @return string
     */
    public function getInput();

    /**
     * Getter for the cursor position
     *
     * @return int
     */
    public function getPosition();

}