<?php

function _map(Callable $fn, Traversable $array) {
    $result = [];

    foreach ($array as $key => $value) {
        $result[] = $fn($value, $key, $array);
    }

    return $result;
}
