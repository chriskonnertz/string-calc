<?php

namespace ChrisKonnertz\StringCalc\Symbols\Concrete\Functions;

use ChrisKonnertz\StringCalc\Exceptions\NumberOfArgumentsException;
use ChrisKonnertz\StringCalc\Symbols\AbstractFunction;

/**
 * In StringCalc it is not possible to write this valid PHP number: 2E3
 * which is called "engineering notation" and will evaluate to
 * 2 * pow(10, 3) = 2000.0 (float) in PHP. This function is a workaround,
 * so instead of "6E12" write "e(2, 3)". Example: "e(2, 3)" => 2000 (int)
 * Attention: As you might have noticed, the result of this function might
 * be an integer while the PHP code always results in a float value!
 */
class EnFunction extends AbstractFunction
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['en'];

    /**
     * @inheritdoc
     */
    public function execute(array $arguments)
    {
        if (sizeof($arguments) != 2) {
            throw new NumberOfArgumentsException('Error: Expected two arguments, got '.sizeof($arguments));
        }

        $number = $arguments[0] * pow(10, $arguments[1]);

        return $number;
    }

}
