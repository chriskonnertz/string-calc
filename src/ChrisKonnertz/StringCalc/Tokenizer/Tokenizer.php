<?php

namespace ChrisKonnertz\StringCalc\Tokenizer;

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
     * @var int[]
     */
    protected $mathChars = [
        33, // !
        37, // %
        38, // &
        42, // *
        43, // +
        45, // -
        47, // /
        60, // <
        61, // =
        62, // >
        94, // ^
        124, // |
    ];

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
     * @throws StringCalcException
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
     * @throws StringCalcException
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
        } elseif ($this->isDollar($char)) {
            $value = $this->readVariable();
            $type = Token::TYPE_VARIABLE;
        } elseif ($this->isDigit($char) or $this->isPeriod($char)) {
            $value = $this->readNumber();
            $type = Token::TYPE_NUMBER;
        } elseif ($this->isMathChar($char)) {
            $value = $this->readMathChars();
            $type = Token::TYPE_MATHCHARS;
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
     * Returns true, if a given character is a math char.
     *
     * @param string|null $char A single character
     * @return bool
     */
    protected function isMathChar($char)
    {
        if ($char === null) {
            return false;
        }

        // Notice: ord(null) will return 0.
        // ord() does not work with utf-8 characters.
        $ascii = ord($char);

        // ASCII codes: 48 = '0', 57 = '9'
        return (in_array($ascii, $this->mathChars));
    }

    /**
     * Returns true, if a given character is a minus sign ('-').
     *
     * @param string|null $char A single character
     * @return bool
     */
    protected function isMinus($char)
    {
        return ($char === '-');
    }

    /**
     * Returns true, if a given character is a exclamation sign ('!') for logical NOT.
     *
     * @param string|null $char A single character
     * @return bool
     */
    protected function isExclamation($char)
    {
        return ($char === '!');
    }

    /**
     * Returns true, if a given character is a underscore sign ('_').
     *
     * @param string|null $char A single character
     * @return bool
     */
    protected function isUnderscore($char)
    {
        return ($char === '_');
    }

    /**
     * Returns true, if a given character is a minus sign ('-').
     *
     * @param string|null $char A single character
     * @return bool
     */
    protected function isDollar($char)
    {
        return ($char === '$');
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
     * Reads a variable. Assumes that the cursor of the input stream
     * currently is positioned at the beginning of a word.
     *
     * @return string
     */
    protected function readVariable()
    {
        $word = '';

        // Try to read the variable
        // first char is dollar
        // second char can be underscore or letter
        // more characters can be underscore, letter or digit
        while (($char = $this->inputStream->readCurrent()) !== null) {
            if (
                ($word === '' && $this->isDollar($char))
                || (strlen($word) === 1
                    && ($this->isLetter($char) || $this->isUnderscore($char))
                )
                || (strlen($word) > 1
                    && ($this->isLetter($char) || $this->isDigit($char)|| $this->isUnderscore($char))
                )
            ) {
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
     * Reads a math chars that are together like '<=' or '||'.
     * Assumes that the cursor of the input stream
     * currently is positioned at the beginning of a word.
     *
     * @return string
     */
    protected function readMathChars()
    {
        $chars = '';

        // Try to read the word
        while (($char = $this->inputStream->readCurrent()) !== null) {

            if (($this->isMinus($char) || $this->isExclamation($char)) && strlen($chars) > 0) {
                // fix for unary operator minus after other math chars
                break;
            }
            if ($this->isMathChar($char)) {
                $chars .= $char;
            } else {
                break;
            }

            // Just move the cursor to the next position
            $this->inputStream->readNext();
        }

        return $chars;
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
