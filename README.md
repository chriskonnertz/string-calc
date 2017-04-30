# StringCalc

StringCalc is a PHP calculator library for mathematical terms (expressions) passed as strings.

````
╔═════════════════════════════════════════════════════════════════════════════════════════╗
║ WARNING: This library is in a very early state (alpha) and is not stable at the moment. ║
╚═════════════════════════════════════════════════════════════════════════════════════════╝
````

## Installation

Through Composer:

```
composer require chriskonnertz/string-calc
```

From now on you can run `composer update` to get the latest version of this library.

It is possible to use this library without using Composer but then it is necessary to register an 
[autoloader function](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md#example-implementation).

## Usage example

Here is a minimalistic example of PHP code that calculates a term. It assumes that there is an autoloader.

```
$stringCalc = new ChrisKonnertz\StringCalc\StringCalc();

$term = '1+2';

$result = $stringCalc->calculate($term);
```

> There is a demo PHP script included. It is located at `dev/demo.php`.

## The term

Example, we need an example! Here we go: `2*(pi-abs(-0.4))`

This is a mathematical term following syntactical and grammatical rules that StringCalc understands. 
Syntax and grammar of these terms are very similar to what you would write in PHP code. 
To be more precise, there is an intersecting set of syntactical and grammatical rules. 
There are some exceptions but usually you will be able to write terms for StringCalc 
by pretending that you are writing PHP code. 

## Types of symbols

A term consists of symbols that are of a specific type. This section lists all available symbol types.

### Numbers

Numbers in a term always consist of digits and may include one period. Good examples:

```
0
00
123
4.56
.7
```

Bad examples:

```
0.1.2   // Two periods
2.2e3   // "e" will work in PHP code but not in a term
7E-10   // "E" will work in PHP code but not in a term
```

Just for your information: From the tokenizer's point of view, numbers in a term are always positive. 
This means that the tokenizer will split the term `-1` in two parts: `-` and `1`. 

> Notice: The fractional part of a PHP float can only have a limited length. If a number in a term has a longer 
fractional part, the fractional part will be cut somewhere.

#### Number implementation

There is only one concrete number class: `Symbols\Concrete\Number`. 
It extends the abstract class `Symbols\AbstractNumber`. It does not implement any behaviour. 
It is basically a placeholder for concrete numbers in the term.

### Brackets

There are two types of brackets in a term: Opening and closing brackets. There is no other typification. For example 
there can be classes that implement support for parentheses `()` and square brackets `[]` 
but they will be treated equally. Therefore this is a valid term even though it might not be valid 
from a mathematical point of view: `[1+)`

For every opening brackets there must be a closing bracket and vice versa. Good examples:
                                                                           
```
(1+1)
(1)
((1+2)*(3+4))
```

Bad examples:

```
(1+1    // Missing closing bracket
1+1)    // Missing opening bracket
)1+1(   // Missing opening bracket for the closing bracket, missing closing bracket for the open bracket
```

#### Bracket implementation

The `Symbols\AbstractBracket` class is the base class for all brackets. It is extended by the abstract classes
`Symbols\AbstractOpeningBracket` and `Symbols\AbstractClosingBracket`. These are extended by concrete classes: 
`Symbols\Concrete\OpeningBracket` and `Symbols\Concrete\ClosingBracket`. These classes do not implement behaviour.

### Constants

Constants in a term typically represent mathematical constants, for example pi.
 
Examples:
```
pi
PI
1+pi*2
```

#### Constant implementation

The `Symbols\AbstractConstant` class is the base class for all constants. 
There are several concrete constants that extend this class.

Constants classes have a property called `value` that stores the value of the constant. It is possible to overwrite this
value in a concrete constant class or to overwrite the getter method `getValue`.

### Operators

Operators in a term can be unary or binary or even both. However, if they are unary, they have to follow
 the prefix notation (example: "-1"). 
 
Unary operator example: `-1`
Binary operator example: `2-1`

#### Operator implementation

The `Symbols\AbstractOperator` class is the base class for all operators. 
There are several concrete operators that extend this class.

Please be aware that operators are closely related to functions. Functions are at least as powerful as operators are.
If an operator does not seem suitable for a purpose, a function might be an appropriate alternative.

Operator classes implement the `operate($leftNumber, $rightNumber)` method. Its parameters represent the operands.
It might be confusing that even if the operator is a unary operator its `operate` method needs to have offer
both parameters. The `$rightNumber` parameter will contain the operand of the unary operation while the left will 
contain 0.

### Functions

Functions in a term represent mathematical functions. Typically the textual representation of a function consists of 
two or more letters, for example: `min`

Good examples of using functions:
                                                                           
```
abs(-1)
ABS(-1)
abs(1+abs(2))
min(1,2)
min(1,2,3)
```

Bad examples:

```
abs-1 // Missing brackets
min(1,) // Missing argument
```

> Attention: The comma character is used exclusively as a separator of function arguments. 
It is never interpreted as a decimal mark! Example for the former: max(1,2)

#### Function implementation

The `Symbols\AbstractFunction` class is the base class for all functions. 
There are several concrete functions that extend this class.

Please be aware that operators are closely related to functions. Functions are at least as powerful as operators are.
If an operator does not seem suitable for a purpose, a function might be an appropriate alternative.

Function classes implement the `execute(array $arguments)` method. The arguments are passed as an array to this method. 
The size of the arguments array can be 0-n. The implementation of this method is responsible to validate the number of 
arguments. Example:

```
if (sizeof($arguments) < 1) {
    throw new \InvalidArgumentException('Error: Expected at least one argument, none given.');
}
```

The items of the `$arguments` array will always be of type int or float. They will never be null.

### Separators

...

## Notes

* Internally this library uses PHP's mathematical constants, operators and functions to calculate the term. 
Therefore - as a rule of thumb - please transfer your knowledge about mathematics in PHP to the mathematics 
in StringCalc.  

* This class does not offer support for any other numeral system than the decimal numeral system. 
It is not intended to provide such support so if you need support of other numeral system 
(such as the binary numeral system) this might not be the library of your choice. 

* General advice: The code of this library is well documented. Therefore, do not hesitate to take a closer 
look at the implementation. 

## TODO

* Grammar checking
* Add function for 7E-10 numbers?
* Make injectable grammar checker?
* Make exceptions (way more) verbose?
* Make two operate() methods, for binary and unary operations?
* Rename symbol classes to symbol type classes?
* Check phpdoc comments, especially check for @throws tags
* Write docs
* Publish on Packagist