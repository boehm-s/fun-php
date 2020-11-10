<?php

use boehm_s\F;

//! [pipe]
$isEven     = function($n) { return $n % 2 == 0; };
$square     = function($n) { return $n * $n; };
$addReducer = function($acc, $val) { return $acc + $val; };

F::pipe(
    F::filter($isEven),       //=> [2, 4]
    F::map($square),          //=> [4, 16]
    F::reduce($addReducer, 0) //=> 20
)([1, 2, 3, 4, 5]);           //=> 20
//! [pipe]

//! [compose]
$sayHello = function($name) { return "Hello $name"; };
$yellHello = F::compose('strtoupper', $sayHello);

$yellHello('Punky'); //=> HELLO PUNKY
//! [compose]


//! [partial]
$greet = function($salutation, $title, $name) { return "$salutation $title $name !"; };
$greetDoctor = F::partial($greet, ['Hello', 'Dr.']);
$greetDoctor('Jekyll'); //=> Hello Dr. Jekyll !
//! [partial]
