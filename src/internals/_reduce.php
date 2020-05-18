<?php

function _reduce(Callable $fn, Traversable $array, $identity) {
    $acc = $identity;

    foreach ($array as $key => $value) {
        $acc = $fn($result, $value, $key, $array);
    }

    return $acc;
}
