<?php

namespace ChrisKonnertz\StringCalc\Tokenizer;

use ChrisKonnertz\StringCalc\Support\StringHelperInterface;

class InputStream implements InputStreamInterface
{

    /**
     * This class operates on this string
     *
     * @var string
     */
    protected $input = '';

    /**
     * Current position in the input
     *
     * @var int
     */
    protected $index = 0;

    /**
     * @var StringHelperInterface
     */
    protected $stringHelper;

    /**
     * @param StringHelperInterface $stringHelper
     */
    public function __construct(StringHelperInterface $stringHelper)
    {
        // Dependency: string helper must be assigned before setInput() is called!
        $this->stringHelper = $stringHelper;
    }

    /**
     * Move the pointer to the next position.
     * Will always move the pointer, even if the end of the term has been passed.
     *
     * @return string|null
     */
    public function readNext()
    {
        $this->index++;

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
            $char = $this->input[$this->index];
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
        return ($this->index < strlen($this->input));
    }

    /**
     * Resets the cursor to the beginning of the string.
     *
     * @return void
     */
    public function reset()
    {
        $this->index = 0;
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
    public function getIndex()
    {
        return $this->index;
    }

}