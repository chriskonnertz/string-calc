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

        // Numbers
        $numbers = [
            ['0', 0],
            ['1', 1],
            ['1337', 1337],
            ['1.0', 1.0],
            ['1.23456789', 1.23456789],
        ];

        // Operators
        $operators = [
            ['1+0', 1],
            ['1+1', 2],
            ['-1+1', 0],

            ['1-0', 1],
            ['1-1', 0],
            ['1-2', -1],

            ['1-1-1', -1],
            ['1-1+1', 1],

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

        // Brackets
        $brackets = [
            ['()', 0],
            ['(2)', 2],
            ['((3))', 3],
            ['(1+2)', 3],
            ['(-2)', -2],
            ['((1+2)*(3+4))', 21],
        ];

        $this->doCalculations($numbers + $operators + $brackets);

        // Constants
        $constants = [
            ['e', M_E],
            ['euler', M_EULER],
            ['lnPi', M_LNPI],
            ['lnTen', M_LN10],
            ['lnTwo', M_LN2],
            ['logTenE', M_LOG10E],
            ['logTwoE', M_LOG2E],
            ['onePi', M_1_PI],
            ['pi', M_PI],
            ['piFour', M_PI_4],
            ['piTwo', M_PI_2],
            ['sqrtOneTwo', M_SQRT1_2],
            ['sqrtPi', M_SQRTPI],
            ['sqrtThree', M_SQRT3],
            ['sqrtTwo', M_SQRT2],
            ['twoPi', M_2_PI],
            ['twoSqrtPi', M_2_SQRTPI],
        ];

        // Functions (and Separators)
        $functions = [
            ['abs(-2)', 2],
            ['aCos(0.5)', 1.0471975511966],
            ['aCosH(2)', 1.3169578969248],
            ['aSin(0.5)', 0.5235987755983],
            ['aSinH(2)', 1.4436354751788],
            ['aTan(2)', 1.1071487177941],
            ['aTanH(0.5)', 0.54930614433405],
            ['aTanTwo(2,2)', 0.78539816339745],
            ['ceil(1.2)', 2],
            ['cos(2)', -0.41614683654714],
            ['cosH(2)', 3.7621956910836],
            ['degToRad(2)', 0.034906585039887],
            ['en(2, 3)', 2000],
            ['exp(2)', 7.3890560989307],
            ['expMOne(2)', 6.3890560989307],
            ['floor(2.8)', 2],
            ['fMod(2.2,2.1)', 0.1],
            ['hypot(2,2)', 2.8284271247462],
            ['log(2)', 0.69314718055995],
            ['log(2,2)', 1],
            ['logOneP(2)', 1.0986122886681],
            ['logTen(2)', 0.30102999566398],
            ['max(1,2.2)', 2.2],
            ['min(2,1.1)', 1.1],
            ['pow(2,3)', 8],
            ['radToDeg(2)', 114.59155902616],
            ['round(1.8)', 2],
            ['round(1.84,1)', 1.8],
            ['sin(2)', 0.90929742682568],
            ['sinH(2)', 3.626860407847],
            ['sqrt(2)', 1.4142135623731],
            ['tan(2)', -2.1850398632615],
            ['tanH(2)', 0.96402758007582],
        ];

        // Constants

        // Will call the assertEquals method with the delta parameter set which means assertEquals
        // will report an error if result and expected result  are not within $delta of each other
        $this->doCalculations($constants + $functions, 0.0001);

        // Random functions:
        $this->stringCalc->calculate('getRandMax()');
        $this->stringCalc->calculate('mTGetRandMax()');
        $this->stringCalc->calculate('mTRand()');
        $this->stringCalc->calculate('mTRand(1,2)');
        $this->stringCalc->calculate('rand()');
        $this->stringCalc->calculate('rand(1,2)');
    }

    /**
     * Performs the calculations.
     * $calculations is an array of arrays with two values:
     * value on is a string with the term, value two is the expected result (float or int).
     * Notice: These terms have to be valid!
     *
     * @param array $calculations [array] $calculations
     * @param float $delta
     */
    private function doCalculations(array $calculations, $delta = 0.0)
    {
        foreach ($calculations as $calculation) {
            $term = $calculation[0];
            $expectedResult = $calculation[1];

            $calculatedResult = $this->stringCalc->calculate($term);

            $this->assertEquals($calculatedResult, $expectedResult, 'Term: '.$term, $delta);
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
