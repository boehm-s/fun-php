# fun-php

functional programming utilities for PHP !

## What is it ? 

- It's an **easy-to-use** functional programming library for PHP
- It aim to be PHP's Ramda, but with less functions since it's just a side project.
- It's a bunch of static functions in a class `F` that are very handy for maniuplating objects / arrays

## Why ? 

- Because PHP lacks of simple and easy-to-use utilities for functional programming !
- To prove that we can still have fun with PHP (despite the fact that it's PHP) !!!

# Installation and Usage

Install the library using composer : 

```
composer require boehm_s/fun
```

And then, import it in your files :

```
use boehm_s\F;
```

Everything's up and running, you can play with it !

```
$greetings = [
    ['hello', 'world', '!'],
    ['how', 'are', 'you', '?']
];

$fn = F::compose('strtoupper', F::partial('implode', [' ']));
$values = F::map($fn, $greetings);

echo $values[0]; // "HELLO WORLD !"
```

# Philosophy

Using *fun-php* should be as painless as possible : no weird syntax, no OOP syntax, just functions (everywhere) !

As with Ramda, all the functions are automatically curried, and data comes last so you can easely compose them. Also, placeholders are implemented !
It means that the followings are equivalent : 

```
// F::_ is the placeholder
F::map('strtoupper', ['hello', 'world', '!']);
F::map('strtoupper')(['hello', 'world', '!']);
F::map(F::_, ['hello', 'world', '!'])('strtoupper');
```

# Documentation

# Running the test suite
