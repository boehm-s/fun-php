<?php

require_once(realpath(dirname(__FILE__) . '/_isPlaceholder.php'));
require_once(realpath(dirname(__FILE__) . '/_curry1.php'));

function _curry2($fn) {
    return function($a = null, $b = null) use ($fn) {
        $a__  = _isPlaceholder($a);
        $b__  = _isPlaceholder($b);
        $args = func_get_args();

        switch (count($args)) {
        case 0:
            return function(...$args) use ($fn) { return _curry2($fn)(...$args); };
        case 1:
            return $a__ ? $fn : _curry1(function ($_b) use ($fn, $a) {
                return $fn($a, $_b);
            });
        default:
            if ($a__ && $b__) {
                return $fn;
            } else if ($a__) {
                return _curry1(function ($_a) use($fn, $b) { return $fn($_a, $b); });
            } else if($b__) {
                return _curry1(function ($_b) use($fn, $a) { return $fn($a, $_b); });
            } else
                return $fn($a, $b);
        }
    };
}
