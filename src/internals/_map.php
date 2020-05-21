<?php

require_once(realpath(dirname(__FILE__) . '/_arity.php'));

function _map(Callable $fn, iterable $array) {
    $result = [];
    $fnArity = _arity($fn);

    foreach ($array as $key => $value) {
        $args = [$value, $key, $array];
        $tailoredArgs = array_slice($args, 0, $fnArity);

        $result[] = $fn(...$tailoredArgs);
    }

    return $result;
}
