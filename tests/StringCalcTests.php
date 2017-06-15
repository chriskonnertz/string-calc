<?php

// Ensure backward compatibility
// @see http://stackoverflow.com/questions/42811164/class-phpunit-framework-testcase-not-found#answer-42828632
if (!class_exists('\PHPUnit\Framework\TestCase')) {
    class_alias('\PHPUnit_Framework_TestCase', '\PHPUnit\Framework\TestCase');
}

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
        ];

        $this->doCalculations($calculations);

        $calculations = [
            ['abs(-2)', 2],
            ['aCosH(2)', 1.31695]
        ];

        $this->doCalculations($calculations, 0.0001);
    }

    /**
     * Performs the calculations.
     * $calculations is an array of arrays with two values:
     * value on is a string with the term, value two is the expected result (float or int).
     * Notice: These terms have to be valid!
     *
     * @param array[array] $calculations
     */
    private function doCalculations(array $calculations, $delta = 0)
    {
        foreach ($calculations as $calculation) {
            $term = $calculation[0];
            $expectedResult = $calculation[1];

            $calculatedResult = $this->stringCalc->calculate($term);

            // Use the following line to see the current term:
            //echo $term.' --- ';

            $this->assertEquals($calculatedResult, $expectedResult, '', $delta);
        }
    }

    public function testTokenize()
    {
        $stringCalc = $this->getInstance();

        $term = '1+(2+max(-3,3))';

        $tokens = $stringCalc->tokenize($term);

        $this->assertNotNull($tokens);
    }

    public function testParseAndTraverse()
    {
        $stringCalc = $this->getInstance();

        $term = '1+(2+max(-3,3))';

        $tokens = $stringCalc->tokenize($term);

        $node = $stringCalc->parse($tokens);

        $this->assertNotNull($node);

        $node->traverse(function($node, $level)
        {
            // do nothing
        });
    }

    public function testGetSymbolContainer()
    {
        $stringCalc = $this->getInstance();

        $symbolContainer = $stringCalc->getSymbolContainer();

        $this->assertNotNull($symbolContainer);
    }

    public function testGetContainer()
    {
        $stringCalc = $this->getInstance();

        $container = $stringCalc->getContainer();

        $this->assertNotNull($container);
    }

    public function testAddSymbol()
    {
        $stringCalc = $this->getInstance();

        $container = $stringCalc->getContainer();

        $stringHelper = $container->get('stringcalc_stringhelper');

        $symbol = new ChrisKonnertz\StringCalc\Symbols\Concrete\Constants\PiConstant($stringHelper);

        $replaceSymbol = get_class($symbol);

        $stringCalc->addSymbol($symbol, $replaceSymbol);
    }

}
