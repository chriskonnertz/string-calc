<?php
require_once '../vendor/autoload.php';

$termList       = [
    ['abs(2) + -1+$var+1', 12, ['$var'=>10]],

];
$printTokenized = true;
$printTree      = true;

function calc($term, $variables=[], $expectedResult = null, $printTokenized = true, $printTree = false)
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
                $rootNode = $stringCalc->parse($tokens, $variables);

                $rootNode->traverse(function ($node, $level) {
                    echo str_repeat('_', $level);
                    if ($node instanceof \ChrisKonnertz\StringCalc\Parser\Nodes\ContainerNode) {
                        echo " () \n";
                    }
                    if ($node instanceof \ChrisKonnertz\StringCalc\Parser\Nodes\SymbolNode) {
                        if( $node->getSymbol() instanceof \ChrisKonnertz\StringCalc\Symbols\AbstractVariable){
                            echo " " . $node->getToken()->getValue() . " (".$node->getSymbol()->getValue().")\n";
                        }else{
                            echo " " . $node->getToken()->getValue() . "\n";
                        }
                    }
                    if ($node instanceof \ChrisKonnertz\StringCalc\Parser\Nodes\FunctionNode) {
                        echo " " . $node->getSymbolNode()->getToken()->getValue() . "\n";
                    }
                });
                echo "\n";
            }

            $result = $stringCalc->calculate($term, $variables);

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
        $variables = isset($termDef[2])?$termDef[2]:[];
    }else{
        $term = $termDef;
    }
    echo "Term:\n";
    echo $term ."\n";
    $result = calc($term, $variables, $expectedResult, $printTokenized, $printTree);
    echo "\n\n\n";
    if(!$result){
        break;
    }
}