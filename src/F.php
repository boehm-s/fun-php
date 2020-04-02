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

    private static function _curry3($fn) {
        return $_fn = function($a = null, $b = null, $c = null) use ($fn) {
        	$args = func_get_args();
            switch (count($args)) {
            case 0:
                return $_fn;
            case 1:
                return static::_curry2(function ($_b, $_c) use ($fn, $a) {
                    return $fn($a, $_b, $_c);
                });
            case 2:
                return static::_curry1(function ($_c) use ($fn, $a, $b) {
                    return $fn($a, $b, $_c);
                });
            default:
                return $fn($a, $b, $c);
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
            return array_merge(
                ...array_map($fn, $array)
            );
        })(...$args);
    }

    public static function find(...$args) {
        return static::_curry2(function($fn, $array) {
            foreach ($array as $key => $value) {
                if ($fn($value, $key, $array) === true) {
                    return $value;
                }
            }

            return null;
        })(...$args);
    }

    public static function findIndex(...$args) {
        return static::_curry2(function($fn, $array) {
            foreach ($array as $key => $value) {
                if ($fn($value, $key, $array) === true) {
                    return $key;
                }
            }

            return null;
        })(...$args);
    }

    public static function some(...$args) {
        return static::_curry2(function($fn, $array) {
            foreach ($array as $key => $value) {
                if ($fn($value, $key, $array) === true) {
                    return true;
                }
            }

            return false;
        })(...$args);
    }

    public static function every(...$args) {
        return static::_curry2(function($fn, $array) {
            foreach ($array as $key => $value) {
                if ($fn($value, $key, $array) === false) {
                    return false;
                }
            }

            return true;
        })(...$args);
    }

    public static function sort(...$args) {
        return static::_curry2(function($fn, $array) {
            $copiedArray = is_object($array)
                         ? json_decode( json_encode($array), true) // a bit dirty
                         : $array;

            usort($copiedArray, $fn);
            return $copiedArray;

        })(...$args);
    }

    public static function reverse(...$args) {
        return static::_curry1(function($array) {
            $copiedArray = is_object($array)
                         ? json_decode( json_encode($array), true) // a bit dirty
                         : $array;

            return array_reverse($copiedArray);
        })(...$args);
    }

    public static function reduce(...$args) {
        return static::_curry3(function($fn, $default, $array) {
            return array_reduce($array, $fn, $default);
        })(...$args);
    }

    public static function includes(...$args) {
        return static::_curry2(function($value, $array) {
            return in_array($value, $array);
        })(...$args);
    }



    public static function prop(...$args) {
        return static::_curry2(function($prop, $obj) {
            return $obj[$prop];
        })(...$args);
    }

    public static function pick(...$args) {
        return static::_curry2(function($props, $obj) {
            $newObj = [];
            foreach ($props as $prop) {
                $newObj[$prop] = $obj[$prop];
            }

            return $newObj;
        })(...$args);
    }

    public static function propEq(...$args) {
        return static::_curry3(function($prop, $value, $obj) {
            return $obj[$prop] === $value;
        })(...$args);
    }

    public static function propSatisfies(...$args) {
        return static::_curry3(function($fn, $prop, $obj) {
            return $fn($obj[$prop]) === true;
        })(...$args);
    }


}
