<?php

require_once(realpath(dirname(__FILE__) . '/_isPlaceholder.php'));
require_once(realpath(dirname(__FILE__) . '/_curry1.php'));
require_once(realpath(dirname(__FILE__) . '/_curry2.php'));

function _curry3($fn) {
        return function($a = null, $b = null, $c = null) use ($fn) {
        	$args = func_get_args();
            switch (count($args)) {
            case 0:
                return $fn;
            case 1:
                return _isPlaceholder($a) ? $fn : _curry2(function ($_b, $_c) use ($fn, $a) {
                    return $fn($a, $_b, $_c);
                });
            case 2:
                if (_isPlaceholder($a) && _isPlaceholder($b)) {
                    return $fn;
                } else {
                    if (_isPlaceholder($a)) {
                        return _curry2(function ($_a, $_c) use ($fn, $b) {
                            return $fn($_a, $b, $_c);
                        });
                    } else if (_isPlaceholder($b)) {
                        return _curry2(function ($_b, $_c) use ($fn, $a) {
                            return $fn($a, $_b, $_c);
                        });
                    } else {
                        return _curry1(function ($_c) use ($fn, $a, $b) {
                            return $fn($a, $b, $_c);
                        });
                    }
                }
            default:
                if (_isPlaceholder($a) && _isPlaceholder($b) && _isPlaceholder($c)) {
                    return $fn;
                } else {
                    if (_isPlaceholder($a) && _isPlaceholder($b)) {
                        return _curry2(function ($_a, $_b) use ($fn, $c) {
                            return $fn($_a, $_b, $c);
                        });
                    } else if (_isPlaceholder($a) && _isPlaceholder($c)) {
                        return _curry2(function ($_a, $_c) use($fn, $b) {
                            return $fn($_a, $b, $_c);
                        });
                    } else if (_isPlaceholder($b) && _isPlaceholder($c)) {
                        return _curry2(function ($_b, $_c) use($fn, $a) {
                            return $fn($a, $_b, $_c);
                        });
                    } else if (_isPlaceholder($a)) {
                        return _curry1(function ($_a) use($fn, $b, $c) {
                            return $fn($_a, $b, $c);
                        });
                    } else if (_isPlaceholder($b)) {
                        return _curry1(function ($_b) use($fn, $a, $c) {
                            return $fn($a, $_b, $c);
                        });
                    } else if (_isPlaceholder($c)) {
                        return _curry1(function ($_c) use($fn, $a, $b) {
                            return $fn($a, $b, $_c);
                        });
                    } else {
                        return $fn($a, $b, $c);
                    }
                }
            }
        };
    }
