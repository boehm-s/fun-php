<?php

require_once(realpath(dirname(__FILE__) . '/_arity.php'));

function _filter(Callable $fn, iterable $array) {
    $result = [];
    $fnArity = _arity($fn);

    foreach ($array as $key => $value) {
        $args = [$value, $key, $array];
        $tailoredArgs = array_slice($args, 0, $fnArity);

        if ($fn(...$tailoredArgs)) {
            $result[] = $value;
        }
    }

    return $result;
}

function _partition(Callable $fn, iterable $array) {
    $ok = $ko = [];
    $fnArity = _arity($fn);

    foreach ($array as $key => $value) {
        $args = [$value, $key, $array];
        $tailoredArgs = array_slice($args, 0, $fnArity);

        if ($fn(...$tailoredArgs)) {
            $ok[] = $value;
        } else {
            $ko[] = $value;
        }
    }

    return [$ok, $ko];
}
