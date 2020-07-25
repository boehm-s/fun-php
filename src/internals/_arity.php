<?php

function _arity(Callable $fn) {
    $reflection = new ReflectionFunction($fn);
    $arguments = $reflection->getParameters();

    return count($arguments);
}
