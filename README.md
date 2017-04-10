## [WIP] PHP calculator for mathematical terms (expressions) passed as strings

This library is in a very early state (pre-alpha) and does not work at the moment.

TODO / Missing: 
* Multiple parameters for functions. This is very important bu completely missing yet!
* Grammar checking
* Actual calculation
* Create FunctionSymbolNode node type?
* Add function for 7E-10 numbers?

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

