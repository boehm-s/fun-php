<?php

use boehm_s\F;

//! [filter]
$isEven = function($n) { return $n % 2 == 0; };
F::filter($isEven, [1, 2, 3, 4, 5]); //=> [2, 4]
//! [filter]

//! [partition]
$isEven = function($n) { return $n % 2 == 0; };
F::partition($isEven, [1, 2, 3, 4, 5]); //=> [[2, 4], [1, 3, 5]]
//! [partition]

//! [each]
$isEven = function($n) { return $n % 2 == 0; };
F::each($isEven, [1, 2, 3, 4, 5]); //=> [1, 2, 3, 4, 5]
// has no effect, returns the original input, good for logging / debugging
//! [each]

//! [map]
$square = function($n) { return $n * $n; };
F::map($isEven, [1, 2, 3, 4, 5]); //=> [1, 4, 9, 16, 25]
//! [map]

//! [flatMap]
$pairWithIdx = function($n, $i) { return [$i, $n]; };
F::flatMap($pairWithIdx, [1, 2, 3, 4, 5]); //=> [0, 1, 1, 2, 2, 3, 3, 4, 4, 5]
//! [flatMap]

//! [find]
$moreThan5 = function($n) { return $n > 5; };
$fifth = function($_, $i) { return $i === 4; };
F::find($moreThan5, [1, 2, 3, 4, 5]); //=> null
F::find($fifth, [1, 2, 3, 4, 5]); //=> 5
//! [find]

//! [findIndex]
$moreThan2 = function($n) { return $n > 2; };
F::findIndex($moreThan2, [1, 2, 3, 4, 5]); //=> 2
//! [findIndex]

//! [some]
$equals2 = function($n) { return $n === 2; };
$moreThan5 = function($n) { return $n > 5; };
F::some($equals2, [1, 2, 3, 4, 5]); //=> true
F::some($moreThan5, [1, 2, 3, 4, 5]); //=> false
//! [some]

//! [every]
$equals2 = function($n) { return $n === 2; };
$moreThan0 = function($n) { return $n > 0; };
F::every($equals2, [1, 2, 3, 4, 5]); //=> false
F::every($moreThan0, [1, 2, 3, 4, 5]); //=> true
//! [every]

//! [sort]
$ascNum = function($n1, $n2) { return $n1 - $n2; };
F::sort($ascNum, [4, 5, 3, 1, 2]); //=> [1, 2, 3, 4, 5]
// Warning : When working with objects, they will be modified !
//! [sort]

//! [reverse]
F::reverse([1, 2, 3, 4, 5]); //=> [5, 4, 3, 2, 1]
// Warning : Does not work with objects !
//! [reverse]


//! [reduce]
$addReducer = function($acc, $val) { return $acc + $val; };
$sum = F::reduce($addReducer, 0); // fun-php functions are automatically curried
$sum([1, 2, 3, 4, 5]); //=> 15 (1 + 2 + 3 + 4 + 5)
//! [reduce]

//! [includes]
F::includes(4, [1, 2, 3, 4, 5]); //=> true
F::includes(8, [1, 2, 3, 4, 5]); //=> false
//! [includes]


//! [uniq]
F::uniq([1, 3, 2, 3, 4, 1, 5, 3, 4, 2]); //=> [1, 3, 2, 4, 5]

$arr = ['a' => 1, 'b' => 3, 'c' => 2, 'd' => 3, 'e' => 4, 'f' => 1, 'g' => 5, 'h' => 3, 'i' => 4, 'j' => 2];
F::uniq($arr); //=> [1, 3, 2, 4, 5]
// WARNING : F::uniq re-indexes arrays
//! [uniq]


//! [uniqBy]
$arr = [
    [ 'a' => 4,  'b' => 8],
    [ 'a' => 15, 'b' => 16],
    [ 'a' => 4,  'b' => 23],
];
F::uniqBy(F::prop('a'), $arr); //=> [[ 'a' => 4,  'b' => 8], [ 'a' => 15, 'b' => 16]]
//! [uniqBy]

//! [splitAt]
F::splitAt(2, [1, 2, 3, 4, 5]); //=> [[1, 2], [3, 4, 5]]
F::splitAt(0, [1, 2, 3]); //=> [[], [1, 2, 3]]
//! [splitAt]
