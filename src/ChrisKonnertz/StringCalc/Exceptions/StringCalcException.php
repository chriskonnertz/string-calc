<?php

namespace ChrisKonnertz\StringCalc\Exceptions;

/**
 * This is the base class of all custom exceptions of this library.
 *
 * @package ChrisKonnertz\StringCalc\Exceptions
 */
class StringCalcException extends \Exception
{

    /**
     * The position in the term.
     *
     * @var int
     */
    protected $position = null;

    /**
     * Additional information.
     * ATTENTION: May include user input so use with care!
     *
     * @var string
     */
    protected $subject = null;

    /**
     * Setter for the position property.
     * Will accept invalid values but replace them with 0.
     *
     * @param int $position
     */
    public function setPosition($position)
    {
        $this->position = max((int) $position, 0);
    }

    /**
     * Getter for the position property.
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Setter for the position property.
     *
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * Getter for the position property.
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

}