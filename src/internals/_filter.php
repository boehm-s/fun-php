<?php

function _filter(Callable $fn, iterable $array) {
    $result = [];

    foreach ($array as $key => $value) {
        if ($fn($value, $key, $array)) {
            $result[] = $value;
        }
    }

    return $result;
}
