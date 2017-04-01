<?php namespace ChrisKonnertz\StringCalc\Tokenizer;

use Tokenizer\Tokenizer;

class Tokenizer
{

    /**
     * @var StreamInput
     */
    protected $streamInput;

    /**
     * @var StringHelper
     */
    protected $stringHelper;

    /**
     * @param StreamInput  $streamInput
     * @param StringHelper $stringHelper
     */
    public function __construct(StreamInput $streamInput, StringHelper $stringHelper)
    {
        $this->stringHelper = $stringHelper;

        $this->streamInput = $streamInput;

        $this->allWords = $this->buildAllWords();
    }

    /**
     * @return string[]
     */
    protected function buildAllWords()
    {
        $words = [];

        $this->validateWords(self::OPERATORS);

        return $words;
    }

    /**
     * TODO reimplement
     *
     * @param string[] $symbols
     */
    protected function validateSymbols(array $symbols)
    {
        foreach ($words as $key => $word) {
            if ($word === null) {
                throw new \exception('Error: Word must not be null.');
            }
            if (! is_string($word)) {
                throw new \exception('Error: Word must be a string.');
            }
            if ($word === '') {
                throw new \exception('Error: Word must not be empty.');
            }
            if ($this->stringHelper->containsMultibyte($word)) {
                throw new \exception('Error: Word contains multibyte characters.');
            }
            if (trim($word) === '') {
                throw new \exception('Error: Word must not consist only of whitespace.');
            }
        }

        if (count(array_unique($words)) < count($words)) {
            throw new \exception('Error: Word array must not contain duplicate words.');
        }
    }

    /**
     * @return array
     */
    public function tokenize()
    {
        $this->streamInput->reset();
    }

    protected function readToken()
    {
        $streamInput = $this->streamInput;

        $this->stepOverWhitespace();

        $char = $streamInput->readCurrent();

        if ($char === null) {
            return null;
        }

        if ($this->isWordChar($char)) {
            $this->readWord();
        }
    }

    /**
     * Moves the pointer to the next char that is not whitespace.
     * Might be a null char, might not move the pointer at all.
     */
    protected function stepOverWhitespace()
    {
        while ($this->isWhitepace($this->streamInput->readCurrent())) {
            $this->streamInput->readNext();
        }
    }

    /**
     * Reads a word. Will throw an exception if the attempt to read the word fails.
     *
     * @param string[] $word Array with words. A word must not be null or empty!
     */
    protected function readWord(array $words)
    {
        $word = '';

        // Try to read the word
        while (($char = $this->inputStream->readCurrent()) !== null) {
            $word .= $char;

            if (in_array($word, $words, true)) {
                return $word;
            }
        }

        if ($word === '') {
            // TODO This is a very important exception so add more details to the msg!
            throw new \UnexpectedValueException('Syntax error: Current word is not in list of available words.');
        }

        return $word;
    }

    /**
     * @var string|null $operator
     */
    protected function readOperator()
    {
        return $this->readWord($self::OPERATORS);
    }

    /**
     * Note: A null char is not seen as whitespace.
     *
     * @var string|null $char
     */
    protected function isWhitepace($char)
    {
        return in_array($char, ["\t", "\n"]);
    }

    /**
     *
     * @var string|null $char
     */
    protected function isOperator($char)
    {
        return in_array($char, ['+', '-', '*', '/']);
    }

}