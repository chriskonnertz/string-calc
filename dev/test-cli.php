<?php
require_once '../vendor/autoload.php';

$termList       = [
    ['0||1', 1],
    ['0||-11', 1],
    ['0||0', 0],
    ['0&&1', 0],
    ['0&&-11', 0],
    ['1&&1', 1],
    ['1&&-11', 1],

    ['5==5', 1],
    ['5==4', 0],
    ['5!=5', 0],
    ['5!=4', 1],
    ['5>=5', 1],
    ['5>=4', 1],
    ['4>=5', 0],
    ['5>5', 0],
    ['5>4', 1],
    ['4>5', 0],
    ['5<=5', 1],
    ['5<=4', 0],
    ['4<=5', 1],
    ['5<5', 0],
    ['5<4', 0],
    ['4<5', 1],
    ['if(1,2,3)', 2],
    ['if(0,2,3)', 3],
];
$printTokenized = true;
$printTree      = false;

function calc($term, $expectedResult = null, $printTokenized = true, $printTree = false)
{
    if ($term !== null) {
        try {
            $stringCalc = new ChrisKonnertz\StringCalc\StringCalc();
            $tokens     = $stringCalc->tokenize($term);
            if ($printTokenized) {
                echo "Tokenized: \n";
                foreach ($tokens as $token) {
                    echo ' ' . $token . ' ';
                }
                echo "\n";
            }
            if ($printTree) {

                echo "Structure: \n";
                $rootNode = $stringCalc->parse($tokens);

                $rootNode->traverse(function ($node, $level) {
                    echo str_repeat('__', $level);
                    if ($node instanceof \ChrisKonnertz\StringCalc\Parser\Nodes\ContainerNode) {
                        echo " () \n";
                    }
                    if ($node instanceof \ChrisKonnertz\StringCalc\Parser\Nodes\SymbolNode) {
                        echo " " . $node->getToken()->getValue() . "\n";
                    }
                    if ($node instanceof \ChrisKonnertz\StringCalc\Parser\Nodes\FunctionNode) {
                        echo " " . $node->getSymbolNode()->getToken()->getValue() . "\n";
                    }
                });
                echo "\n";
            }

            $result = $stringCalc->calculate($term);

            echo "Result: \n";
            echo $result . " (Type: " . gettype($result) . ") \n";
            if( $expectedResult !== null ){
                $expectedOk = $result==$expectedResult;
                echo "expected: ". $expectedResult ." (".($expectedOk?"OK":"FAIL").")\n";
                return $expectedOk;
            }
            return true;
        } catch (ChrisKonnertz\StringCalc\Exceptions\StringCalcException $exception) {
            echo "### error : " . $exception->getMessage() . " \n";
            echo "### error : " . $exception->getTraceAsString() . " \n";
            if ($exception->getPosition()) {
                echo "### at position :" . $exception->getPosition() . " \n";
            }
            if ($exception->getSubject()) {
                echo "###  with subject" . $exception->getSubject() . " \n";
            }
        } catch (Exception $exception) {
            echo "### error outside" . $exception->getMessage() . " \n";
        }
    }
    return false;
}


foreach ($termList as $termDef) {
    $term = '';
    $expectedResult = null;
    if( is_array( $termDef ) ){
        $term = isset($termDef[0])?$termDef[0]:'';
        $expectedResult = isset($termDef[1])?$termDef[1]:null;
    }else{
        $term = $termDef;
    }
    echo "Term:\n";
    echo $term ."\n";
    $result = calc($term, $expectedResult, $printTokenized, $printTree);
    echo "\n\n\n";
    if(!$result){
        break;
    }
}