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

    public static function init() {
        self::$filter = static::_curry2(function($fn, $array) {
            return array_values(array_filter($array, $fn, ARRAY_FILTER_USE_BOTH));
        });
    }
}

F::init();


$arr = [1, 2, 3, 4, 5];
$test1 = (F::$filter)(function($i) { return $i > 2; }, $arr);
$test2 = (F::$filter)(function($i) { return $i > 2; })($arr);

var_dump($test1);
var_dump($test2);
