<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete;

use ChrisKonnertz\StringCalc\Symbols\AbstractFunction;

/**
 * In StringCalc it is not possible to write this valid PHP number: 2E3
 * which in PHP will evaluate to 2 * pow(10, 3) = 2000.0 (float).
 * This function is  a workaround, so instead of "6E12" write "e(2, 3)"
 * Example: "e(2, 3)" => 2000 (int)
 * Attention: As you migh have noticed, the result of this function might
 * be an integer while the PHP code always results in a float value!
 */
class EFunction extends AbstractFunction
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['e'];

    /**
     * @inheritdoc
     */
    public function execute(array $arguments)
    {
        if (sizeof($arguments) != 2) {
            throw new \InvalidArgumentException('Error: Expected two arguments, '.sizeof($arguments).' given.');
        }

        $number = $arguments[0] * pow(10, $arguments[1]);

        return $number;
    }

}