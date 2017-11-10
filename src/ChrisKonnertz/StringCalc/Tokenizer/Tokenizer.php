<?php

namespace ChrisKonnertz\StringCalc\Tokenizer;

use ChrisKonnertz\StringCalc\Exceptions\NotFoundException;
use ChrisKonnertz\StringCalc\Exceptions\StringCalcException;
use ChrisKonnertz\StringCalc\Support\StringHelperInterface;

/**
 * "Tokenization is the process of demarcating and possibly classifying
 * sections of a string of input characters" (Source: Wikipedia)
 * The tokenizer operates on the string term and tries to split it into
 * parts (these are the symbols of the term / the tokens).
 * The tokenizer is not very smart, it does not care for grammar.
 *
 * @package ChrisKonnertz\StringCalc\Tokenizer
 */
class Tokenizer
{

    /**
     * @var InputStreamInterface
     */
    protected $inputStream;

    /**
     * @var StringHelperInterface
     */
    protected $stringHelper;

    /**
     * Tokenizer constructor.
     *
     * @param InputStreamInterface     $inputStream
     * @param StringHelperInterface    $stringHelper
     */
    public function __construct(InputStreamInterface $inputStream, StringHelperInterface $stringHelper)
    {
        $this->inputStream = $inputStream;

        $this->stringHelper = $stringHelper;
    }

    /**
     * Tokenize the term. Returns an array with the tokens.
     *
     * @return Token[]
     */
    public function tokenize()
    {
        $this->inputStream->reset();

        $tokens = [];

        while ($token = $this->readToken()) {
            $tokens[] = $token;
        }

        return $tokens;
    }

    /**
     * Reads a token.
     *
     * @return Token|null
     * @throws NotFoundException
     */
    protected function readToken()
    {
        $inputStream = $this->inputStream;

        $this->stepOverWhitespace();

        $char = $inputStream->readCurrent();

        if ($char === null) {
            return null;
        }

        if ($this->isLetter($char)) {
            $value = $this->readWord();
            $type = Token::TYPE_WORD;
        } elseif ($this->isDigit($char) or $this->isPeriod($char)) {
            $value = $this->readNumber();
            $type = Token::TYPE_NUMBER;
        } else {
            $value = $this->readChar();
            $type = Token::TYPE_CHARACTER;
        }

        $token = new Token($value, $type, $this->inputStream->getPosition());

        return $token;
    }

    /**
     * Returns true, if a given character is a letter (a-z and A-Z).
     *
     * @param string $char A single character
     * @return bool
     */
    protected function isLetter($char)
    {
        if ($char === null) {
            return false;
        }

        // Notice: ord(null) will return 0.
        // ord() does not work with utf-8 characters.
        $ascii = ord($char);

        // ASCII codes: 65 = 'A', 90 = 'Z', 97 = 'a', 122 = 'z'
        return (($ascii >= 65 and $ascii <= 90) or ($ascii >= 97 and $ascii <= 122));
    }

    /**
     * Returns true, if a given character is a digit (0-9).
     *
     * @param string|null $char A single character
     * @return bool
     */
    protected function isDigit($char)
    {
        if ($char === null) {
            return false;
        }

        // Notice: ord(null) will return 0.
        // ord() does not work with utf-8 characters.
        $ascii = ord($char);

        // ASCII codes: 48 = '0', 57 = '9'
        return ($ascii >= 48 and $ascii <= 57);
    }

    /**
     * Returns true, if a given character is a period ('.').
     *
     * @param string|null $char A single character
     * @return bool
     */
    protected function isPeriod($char)
    {
        return ($char === '.');
    }

    /**
     * Returns true, if a given character is whitespace.
     * Notice: A null char is not seen as whitespace.
     *
     * @var string|null $char
     * @return bool
     */
    protected function isWhitespace($char)
    {
        return in_array($char, [" ", "\t", "\n"]);
    }

    /**
     * Moves the pointer to the next char that is not whitespace.
     * Might be a null char, might not move the pointer at all.
     *
     * @return void
     */
    protected function stepOverWhitespace()
    {
        while ($this->isWhitespace($this->inputStream->readCurrent())) {
            $this->inputStream->readNext();
        }
    }

    /**
     * Reads a word. Assumes that the cursor of the input stream
     * currently is positioned at the beginning of a word.
     *
     * @return string
     */
    protected function readWord()
    {
        $word = '';

        // Try to read the word
        while (($char = $this->inputStream->readCurrent()) !== null) {
            if ($this->isLetter($char)) {
                $word .= $char;
            } else {
                break;
            }

            // Just move the cursor to the next position
            $this->inputStream->readNext();
        }

        return $word;
    }

    /**
     * Reads a number (as a string). Assumes that the cursor
     * of the input stream currently is positioned at the
     * beginning of a number.
     *
     * @return string
     * @throws StringCalcException
     */
    protected function readNumber()
    {
        $number = '';
        $foundPeriod = false;

        // Try to read the number.
        // Notice: It does not matter if the number only consists of a single period
        // or if it ends with a period.
        while (($char = $this->inputStream->readCurrent()) !== null) {
            if ($this->isPeriod($char) or $this->isDigit($char)) {
                if ($this->isPeriod($char)) {
                    if ($foundPeriod) {
                        throw new StringCalcException('Error: A number cannot have more than one period');
                    }

                    $foundPeriod = true;
                }

                $number .= $char;
            } else {
                break;
            }

            // Just move the cursor to the next position
            $this->inputStream->readNext();
        }

        return $number;
    }

    /**
     * Reads a single char. Assumes that the cursor of the input stream
     * currently is positioned at a char (not on null).
     *
     * @return string
     */
    protected function readChar()
    {
        $char = $this->inputStream->readCurrent();

        // Just move the cursor to the next position
        $this->inputStream->readNext();

        return $char;
    }

}
