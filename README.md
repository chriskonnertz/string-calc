## [WIP] PHP calculator for mathematical terms (expressions) passed as strings

This library is in a very early state (pre-alpha) and does not work at the moment.

TODO / Missing: 
* Multiple parameters for functions. This is very important but completely missing yet!
* Deal with unary operators
* Care for operator precedence (WIP)
* Grammar checking
* Actual calculation
* Add function for 7E-10 numbers?

## The term

Example, we need an example! Here we go: `2*(pi-abs(-0.4))`

This is a mathematical term following syntactical and grammatical rules that StringCalc understands. 
Syntax and grammar of these terms are very similar to what you would write in PHP code. 
To be more precise, there is an intersecting set of syntactical and grammatical rules. 
There are some exceptions but usually you will be able to write terms for StringCalc 
by pretending that you are writing PHP code. 

## Types of symbols

A term consists of symbols that are from a specific type. This section list all available symbol types.

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
0.1.2 // Two periods
2.2e3 // "e" will work in PHP code but not in a term
7E-10 // "E" will work in PHP code but not in a term
```

Just for your information: From the tokenizer's point of view, numbers in a term are always positive. 
This means that the tokenizer will split the term `-1` in two parts: `-` and `1`. 

> Notice: The fractional part of a PHP float can only have a limited length. If a number in a term has a longer 
fractional part, the fractional part will be cut somewhere.

### Brackets

...

### Constants

...

### Operators

..

### Functions

...

## Notes

Internally this library uses PHP's mathematical constants, operators and functions to calculate the term. 
Therefore - as a rule of thumb - please transfer your knowledge about mathematics in PHP to the mathematics 
in StringCalc.  