<?php

namespace ChrisKonnertz\StringCalc\Tokenizer;

use ChrisKonnertz\StringCalc\Support\StringHelperInterface;

/**
 * This class operates on the lowest level on an input stream.
 * It can read an input stream (in this case a string). Call
 * the readCurrent() method to read the input at the current
 * position.
 *
 * @package ChrisKonnertz\StringCalc\Tokenizer
 */
class InputStream implements InputStreamInterface
{

    /**
     * This class operates on this string
     *
     * @var string
     */
    protected $input = '';

    /**
     * Current position in the input stream
     *
     * @var int
     */
    protected $position = 0;

    /**
     * @var StringHelperInterface
     */
    protected $stringHelper;

    /**
     * InputStream constructor.
     *
     * @param StringHelperInterface $stringHelper
     */
    public function __construct(StringHelperInterface $stringHelper)
    {
        $this->stringHelper = $stringHelper;
    }

    /**
     * Move the the cursor to the next position.
     * Will always move the cursor, even if the end of the string has been passed.
     *
     * @return string|null
     */
    public function readNext()
    {
        $this->position++;

        return $this->readCurrent();
    }

    /**
     * Returns the current character.
     *
     * @return string|null
     */
    public function readCurrent()
    {
        if ($this->hasCurrent()) {
            $char = $this->input[$this->position];
        } else {
            $char = null;
        }

        return $char;
    }

    /**
     * Returns true if there is a character at the current position
     *
     * @return bool
     */
    public function hasCurrent()
    {
        return ($this->position < strlen($this->input));
    }

    /**
     * Resets the position of the cursor to the beginning of the string.
     *
     * @return void
     */
    public function reset()
    {
        $this->position = 0;
    }

    /**
     * Setter for the input string
     *
     * @param string $input
     */
    public function setInput($input)
    {
        $this->stringHelper->validate($input);

        $this->input = $input;
    }

    /**
     * Getter for the input string
     *
     * @return string
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * Getter for the cursor position
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

}