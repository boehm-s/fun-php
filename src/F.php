<?php

namespace boehm_s;

class F {
    public static $filter;

    private static function _curry1($fn) {
        return $_fn = function ($a) use ($fn) {
        	$args = func_get_args();
            return count($args) === 0 ? $_fn : call_user_func_array($fn, $args);
        };
    }

    private static function _curry2($fn) {
        return $_fn = function($a = null, $b = null) use ($fn) {
        	$args = func_get_args();
            switch (count($args)) {
            case 0:
                return $_fn;
            case 1:
                return static::_curry1(function ($_b) use ($fn, $a) {
                    return $fn($a, $_b);
                });
            default:
                return $fn($a, $b);
            }
        };
    }

    public static function filter(...$args) {
        return static::_curry2(function($fn, $array) {
            return array_values(array_filter($array, $fn, ARRAY_FILTER_USE_BOTH));
        })(...$args);
    }

    public static function map(...$args) {
        return static::_curry2(function($fn, $array) {
            return array_map($fn, $array);
        })(...$args);
    }

    public static function flatMap(...$args) {
        return static::_curry2(function($fn, $array) {
            return array_merge( // [[1, 2], [3, 4], 5].flatMap(x => x) Not working this way !
                ...array_map($fn, $array)
            );
        })(...$args);
    }

}
