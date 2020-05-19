<?php

function _map(Callable $fn, iterable $array) {
    $result = [];

    foreach ($array as $key => $value) {
        $result[] = $fn($value, $key, $array);
    }

    return $result;
}
