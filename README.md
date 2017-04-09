## [WIP] PHP calculator for mathematical terms (expressions) passed as strings

This library is in a very early state (pre-alpha) and does not work at the moment.

## Numbers

Numbers in a term always consist of digits and may include one dot. Good examples:

```
0
123
4.56
.5
```

Bad examples:

```
0.1.2
2.2e3
7E-10
```

From the tokenizer's point of view, numbers in a term are always positive. This means that the tokenizer will split the 
term `-1` in two parts: `-` and `1`. 

> Attention: The fractional part of a PHP float can only have a limited length. If the number has a longer 
fractional part, it will be cut.