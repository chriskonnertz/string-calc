<?php namespace ChrisKonnertz\StringCalc\Tokenizer;

use ChrisKonnertz\StringCalc\Support\StringHelper;

class InputStream
{

    /**
     * @var string
     */
    protected $input;

    /**
     * Current position in the input
     *
     * @var int
     */
    protected $index = 0;

    /**
     * @var StringHelper
     */
    protected $stringHelper;

    /**
     * @param string       $input
     * @param StringHelper $stringHelper
     */
    public function __construct($input, StringHelper $stringHelper)
    {
        // Dependency: string helper must be assigned before setTerm() is called!
        $this->stringHelper = $stringHelper;

        $this->setInput($input);
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
     * @return bool
     */
    public function hasCurrent()
    {
        return ($this->index < strlen($this->input));
    }

    /**
     * @return void
     */
    public function reset()
    {
        $this->index = 0;
    }

    /**
     * @param string $input
     */
    public function setInput($input)
    {
        $this->stringHelper->validate($input);

        $this->input = $input;
    }

    /**
     * @return string
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }

}