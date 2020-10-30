# fun-php

# fun-php 

<div class="badges">
![Build Status](https://travis-ci.com/boehm-s/fun-php.svg?branch=master) 
![codecov](https://codecov.io/gh/boehm-s/fun-php/branch/master/graph/badge.svg?token=LIWXGDM2NN)
</div>

A practical functional library for PHP programmers.

## What is it ? 

- It's an **easy-to-use** functional programming library for PHP
- It aim to be PHP's Ramda, but with less functions since it's just a side project.
- It's a bunch of static functions in a class `F` that are very handy for maniuplating objects / arrays

## Why ? 

- Because PHP lacks of simple and easy-to-use utilities for functional programming !
- To prove that we can still have fun with PHP !

# Installation and Usage

Install the library using composer : 

```
composer require boehm_s/fun
```

And then, import it in your files :

```php
use boehm_s\F;
```

Everything's up and running, you can play with it !

```php
$greetings = ['hello', 'world', '!'],

$yellList = F::compose(
  F::partial('implode', [' ']),
  F::map('strtoupper')
);

$yellList($greetings); // "HELLO WORLD !"
```

# Philosophy

Using *fun-php* should be as painless as possible : no weird syntax, no OOP syntax, just functions (everywhere) !

As with Ramda, all the functions are automatically curried, and data comes last so you can easely compose them. Also, placeholders are implemented !
It means that the followings are equivalent : 

```php
// F::_ is the placeholder

F::map('strtoupper', ['hello', 'world', '!']);
F::map('strtoupper')(['hello', 'world', '!']);
F::map(F::_, ['hello', 'world', '!'])('strtoupper');
```

# Documentation

Please review the [API documentation](/fun-php/classboehm__s_1_1F.html#a1712c41e5be41e6f6e2088ed5d54a864 "API documentation")

# Running the test suite

To run the test suite, you'll need `composer` to be installed. 

Then, install the dependencies (phpunit) : 

```
composer install
```

And run the test : 

```
composer test
```
