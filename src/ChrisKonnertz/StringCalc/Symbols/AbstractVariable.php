<?php

namespace ChrisKonnertz\StringCalc\Symbols;

/**
 * This class is the class that represents symbols of type "variable".
 * Variables are completely handled by the tokenizer/parser so there is no need to
 * create more than one concrete, empty number class (named "Variable").
 * If there is more than one class that inherits this class and
 * is added to the symbol container, an exception will be thrown.
 */
abstract class AbstractVariable extends AbstractSymbol
{
    /**
     * This is the value of the variable. We use 0 as an default here,
     * but it will be overwritten from provided variable list.
     *
     * @var int|float
     */
    protected $value = 0;

    /**
     * Getter for the value property.
     * Typically the value of the constant should be stored in $this->value.
     * However, in case you want to calculate the value at runtime,
     * feel free to overwrite this getter method.
     *
     * @return int|float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param float|int $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }


}