Grammar draft
==

_Draft for a grammar for terms that StringCalc can process._

**Grammar vs Implementation**

It is important that you notice that the implementations of the 
parser (`Parser\Parser` class) and the calculator (`Calculator\Calculator` class) 
do not mimic the production rules defined below exactly.
So don't be irritated if you compare the actual implementation with the
grammar rules.

**Grammar Definition**

expression := number | constant | function
expression := openingBracket expression closingBracket
expression := [unaryOperator] expression (operator [unaryOperator] expression)*

function := functionBody openingBracket closingBracket
function := functionBody openingBracket expression (argumentSeparator expression)* closingBracket





