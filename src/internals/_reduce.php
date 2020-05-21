<?php

require_once(realpath(dirname(__FILE__) . '/_arity.php'));

function _reduce(Callable $fn, iterable $array, $identity) {
    $acc = $identity;
    $fnArity = _arity($fn);

    foreach ($array as $key => $value) {
        $args = [$acc, $value, $key, $array];
        $tailoredArgs = array_slice($args, 0, $fnArity);

        $acc = $fn(...$tailoredArgs);
    }

    return $acc;
}
