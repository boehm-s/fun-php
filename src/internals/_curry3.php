<?php

require_once(realpath(dirname(__FILE__) . '/_isPlaceholder.php'));
require_once(realpath(dirname(__FILE__) . '/_curry1.php'));
require_once(realpath(dirname(__FILE__) . '/_curry2.php'));

function _curry3_2_args($fn, $a, $b) {
    $a__ = _isPlaceholder($a);
    $b__ = _isPlaceholder($b);

    if ($a__ && $b__) {
        return $fn;
    } else if ($a__) {
        return _curry2(function ($_a, $_c) use ($fn, $b) { return $fn($_a, $b, $_c); });
    } else if ($b__) {
        return _curry2(function ($_b, $_c) use ($fn, $a) { return $fn($a, $_b, $_c); });
    } else {
        return _curry1(function ($_c) use ($fn, $a, $b) { return $fn($a, $b, $_c); });
    }
}

function _curry3_3_args($fn, $a, $b, $c) {
    $a__ = _isPlaceholder($a);
    $b__ = _isPlaceholder($b);
    $c__ = _isPlaceholder($c);

    if ($a__ && $b__ && $c__) {
        return $fn;
    } else if ($a__ && $b__) {
        return _curry2(function ($_a, $_b) use ($fn, $c) { return $fn($_a, $_b, $c); });
    } else if ($a__ && $c__) {
        return _curry2(function ($_a, $_c) use($fn, $b) { return $fn($_a, $b, $_c); });
    } else if ($b__ && $c__) {
        return _curry2(function ($_b, $_c) use($fn, $a) { return $fn($a, $_b, $_c); });
    } else if ($a__) {
        return _curry1(function ($_a) use($fn, $b, $c) { return $fn($_a, $b, $c); });
    } else if ($b__) {
        return _curry1(function ($_b) use($fn, $a, $c) { return $fn($a, $_b, $c); });
    } else if ($c__) {
        return _curry1(function ($_c) use($fn, $a, $b) { return $fn($a, $b, $_c); });
    } else {
        return $fn($a, $b, $c);
    }
}

function _curry3($fn) {
    return function($a = null, $b = null, $c = null) use ($fn) {
        $args = func_get_args();
        switch (count($args)) {
        case 0:
            return function(...$args) use ($fn) { return _curry3($fn)(...$args); };
        case 1:
            return _isPlaceholder($a) ? $fn : _curry2(function ($_b, $_c) use ($fn, $a) {
                return $fn($a, $_b, $_c);
            });
        case 2:
            return _curry3_2_args($fn, $a, $b);
        default:
            return _curry3_3_args($fn, $a, $b, $c);
        }
    };
}
