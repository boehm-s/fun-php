<?php

function _reduce(Callable $fn, iterable $array, $identity) {
    $acc = $identity;

    foreach ($array as $key => $value) {
        $acc = $fn($acc, $value, $key, $array);
    }

    return $acc;
}
