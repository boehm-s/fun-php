<?php

use boehm_s\F;

//! [prop]
F::prop('x', ['x' => 42]); //=> 42
F::prop('y', ['x' => 42]); //=> null
F::prop(1, [42, 21]); //=> 21
//! [prop]

//! [propOr]
F::propOr('x', 666, ['x' => 42]); //=> 42
F::propOr('y', 666, ['x' => 42]); //=> 666
F::propOr(42, ['foo' => 'bar'], [42, 21]); //=> ['foo' => 'bar']
//! [propOr]

//! [propEq]
F::propEq('x', 42, ['x' => 42]); //=> true
F::propEq('x', 666, ['x' => 42]); //=> false

$travels = [['type' => 'train', 'id' => 11], ['type' => 'flight', 'id' => 42], ['type' => 'hotel', 'id' => 45]];
F::find(F::propEq('type', 'flight'), $travels); //=> ['type' => 'flight', 'id' => 42]
//! [propEq]

//! [propSatisfies]
F::propSatisfies(function($x) { return $x > 1; }, 'p', ['p' => 42]); //=> true

$travels = [['type' => 'train', 'id' => 11], ['type' => 'flight', 'id' => 42], ['type' => 'hotel', 'id' => 45]];
$isFlightOrTrain = F::includes(F::_, ['train', 'flight']);
F::filter(F::propSatisfies($isFlightOrTrain, 'type'), $travels); //=> [['type' => 'train', 'id' => 11], ['type' => 'flight', 'id' => 42]]
//! [propSatisfies]


//! [pick]
F::pick(['x', 'z'], ['x' => 42, 'y' => 21, 'z' => 2]); //=> ['x' => 42, 'z' => 2]
F::pick(['x', 'a', 'b'], ['x' => 42, 'y' => 21, 'z' => 2]); //=> ['x' => 42]
//! [pick]

//! [merge]
F::merge(['x' => 42, 'y' => 21], ['z' => 2]); //=> ['x' => 42, 'y' => 21, 'z' => 2]
F::merge(['x' => 42], ['y' => 21], ['z' => 2]); //=> ['x' => 42, 'y' => 21, 'z' => 2]
F::merge(['x' => 42, 'y' => 21], ['x' => 'HAHA', 'z' => 2]); //=> ['x' => 'HAHA', 'y' => 21, 'z' => 2]
//! [merge]
