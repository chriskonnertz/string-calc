<?php

/**
 * Class StringCalcTest for tests with PHPUnit.
 */
class StringCalcTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var \ChrisKonnertz\StringCalc\StringCalc|null
     */
    private $stringCalc = null;

    /**
     * Creates and returns an instance of the main class
     *
     * @return \ChrisKonnertz\StringCalc\StringCalc
     */
    protected function getInstance()
    {
        return new ChrisKonnertz\StringCalc\StringCalc();
    }

    public function testCalculations()
    {
        $this->stringCalc = $this->getInstance();

        $calculations = [
            ['0', 0],
            ['1', 1],
            ['1337', 1337],
            ['1.0', 1.0],
            ['1.23456789', 1.23456789],

            ['1+0', 1],
            ['1+1', 2],
            ['-1+1', 0],

            ['1-0', 1],
            ['1-1', 0],
            ['1-2', -1],

            ['1*0', 0],
            ['1*1', 1],
            ['2*2', 4],
            ['-1*1', -1],
            ['-1*-1', 1],

            ['1/1', 1],
            ['2/1', 2],
            ['1/2', 0.5],
            ['-1/2', -0.5],

            ['abs(2)', 2],
            ['abs(-2)', 2],
        ];

        $this->doCalculations($calculations);
    }

    /**
     * Performs the calculations.
     * $calculations is an array of arrays with two values:
     * value on is a string with the term, value two is the expected result (float or int).
     * Notice: These terms have to be valid!
     *
     * @param array[array] $calculations
     */
    private function doCalculations(array $calculations)
    {
        foreach ($calculations as $calculation) {
            $term = $calculation[0];
            $expectedResult = $calculation[1];

            $calculatedResult = $this->stringCalc->calculate($term);

            // Use the following line to see the current term:
            //echo $term.' --- ';

            $this->assertEquals($calculatedResult, $expectedResult);
        }
    }

}
