<?php namespace ChrisKonnertz\StringCalc\Tokenizer;

use ChrisKonnertz\StringCalc\Support\StringHelper;

class InputStream {

	/** 
	 * @var string
	 */
	protected $term;

	/**
	 * Current position in the term
	 * @var int
	 */
	protected $index = 0;

	/**
	 * @var StringHelper
	 */
	protected $stringHelper;

	/**
	 * @param string $term
     * @param StringHelper $stringHelper 
	 */
	public function __construct($term, StringHelper $stringHelper)
	{
        // Dependency: string helper must be assigned before setTerm() is called!
		$this->stringHelper = $stringHelper;

		$this->setTerm($term);
	}

	/**
	 * Move the pointer to the next position.
	 * Will always move the pointer, even if the end of the term has been passed.
	 * 
	 * @return string|null
	 */
	public function readNext()
	{
		$this->$index++;

		return $this->readCurrent();
	}

	/**
	 * @return string|null
	 */
	public function readCurrent()
	{
		if ($this->hasCurrent()) {
			$char = $term[$this->index];
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
		return ($this->index < strlen($this->term));
	}

	/**
	 * @return void
	 */
	public function reset()
	{
		$this->index = 0;
	}

	/**
	 * @param string $term
	 */
	public function setTerm($term)
	{
		$this->stringHelper->validate($term);

		$this->term = $term;
	}

	/**
	 * @return string
	 */
	public function getTerm()
	{
		return $this->term;
	}

	/**
	 * @return int
	 */
	public function getIndex()
	{
		return $this->index;
	}

}