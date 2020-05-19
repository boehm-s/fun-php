<?php

require_once(realpath(dirname(__FILE__) . '/_isPlaceholder.php'));
require_once(realpath(dirname(__FILE__) . '/_curry1.php'));

function _curry2($fn) {
    return function($a = null, $b = null) use ($fn) {
        $args = func_get_args();
        switch (count($args)) {
        case 0:
            return $fn;
        case 1:
            return _isPlaceholder($a) ? $fn : _curry1(function ($_b) use ($fn, $a) {
                return $fn($a, $_b);
            });
        default:
            if (_isPlaceholder($a) && _isPlaceholder($b)) {
                return $fn;
            } else if (_isPlaceholder($a)) {
                return _curry1(function ($_a) use($fn, $b) {
                    return $fn($_a, $b);
                });
            } else if(_isPlaceholder($b)) {
                return _curry1(function ($_b) use($fn, $a) {
                    return $fn($a, $_b);
                });
            } else {
                return $fn($a, $b);
            }
        }
    };
}
