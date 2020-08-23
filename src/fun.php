<?php

namespace boehm_s;

require_once(realpath(dirname(__FILE__) . '/internals/_curry1.php'));
require_once(realpath(dirname(__FILE__) . '/internals/_curry2.php'));
require_once(realpath(dirname(__FILE__) . '/internals/_curry3.php'));
require_once(realpath(dirname(__FILE__) . '/internals/_isPlaceholder.php'));
require_once(realpath(dirname(__FILE__) . '/internals/_filter.php'));
require_once(realpath(dirname(__FILE__) . '/internals/_map.php'));
require_once(realpath(dirname(__FILE__) . '/internals/_reduce.php'));


class F {
    const _ = '@@fun-php/placeholder';

    /**
     * Takes a predicate and a `iterable` and returns an array containing the members
     * of the given iterable which satisfy the given predicate.
     *
     * @param Callable $predicate
     * @param iterable $arr
     * @return array
     */
    public static function filter(...$args) {
        return _curry2(function($fn, $array) {
            return _filter($fn, $array);
        })(...$args);
    }

    /**
     * Iterate over an `iterable`, calling a provided function $fn for each element.
     * Returns the original array
     *
     * @param Callable $fn
     * @param iterable $arr
     * @return array
     */
    public static function each(...$args) {
        return _curry2(function($fn, $array) {
            foreach ($array as $value) {
                $fn($value);
            }
            return $array;
        })(...$args);
    }

    /**
     * Takes a function and a `iterable` and returns an array containing the results
     * of function applied to each iterable values.
     *
     * @param Callable $fn
     * @param iterable $arr
     * @return array
     */
    public static function map(...$args) {
        return _curry2(function($fn, $array) {
            return _map($fn, $array);
        })(...$args);
    }

    /**
     * Takes a function and a `iterable`, apply the function to each of the iterable
     * value and then flatten the result.
     *
     * @param Callable $fn
     * @param iterable $arr
     * @return array
     */
    public static function flatMap(...$args) {
        return _curry2(function($fn, $array) {
            $results = _map($fn, $array);

            return empty($results) ? [] : array_merge(...$results);
        })(...$args);
    }

    /**
     * Returns the first element of the list which matches the predicate, or null if
     * no element matches.
     *
     * @param Callable $predicate
     * @param iterable $arr
     * @return array
     */
    public static function find(...$args) {
        return _curry2(function($fn, $array) {
            foreach ($array as $key => $value) {
                if ($fn($value, $key, $array) === true) {
                    return $value;
                }
            }

            return null;
        })(...$args);
    }

    /**
     * Returns the index of the first element of the list which matches the predicate,
     * or null if no element matches.
     *
     * @param Callable $predicate
     * @param iterable $arr
     * @return array
     */
    public static function findIndex(...$args) {
        return _curry2(function($fn, $array) {
            foreach ($array as $key => $value) {
                if ($fn($value, $key, $array) === true) {
                    return $key;
                }
            }

            return null;
        })(...$args);
    }

    public static function some(...$args) {
        return _curry2(function($fn, $array) {
            foreach ($array as $key => $value) {
                if ($fn($value, $key, $array) === true) {
                    return true;
                }
            }

            return false;
        })(...$args);
    }

    public static function every(...$args) {
        return _curry2(function($fn, $array) {
            foreach ($array as $key => $value) {
                if ($fn($value, $key, $array) === false) {
                    return false;
                }
            }

            return true;
        })(...$args);
    }

    public static function sort(...$args) {
        return _curry2(function($fn, $array) {
            $copiedArray = is_object($array)
                         ? json_decode( json_encode($array), true) // a bit dirty
                         : $array;

            usort($copiedArray, $fn);
            return $copiedArray;

        })(...$args);
    }

    public static function reverse(...$args) {
        return _curry1(function($array) {
            $copiedArray = is_object($array)
                         ? json_decode( json_encode($array), true) // a bit dirty
                         : $array;

            return array_reverse($copiedArray);
        })(...$args);
    }

    public static function reduce(...$args) {
        return _curry3(function($fn, $default, $array) {
            return _reduce($fn, $array, $default);
        })(...$args);
    }

    public static function includes(...$args) {
        return _curry2(function($value, $array) {
            return in_array($value, $array);
        })(...$args);
    }



    public static function prop(...$args) {
        return _curry2(function($prop, $obj) {
            return $obj[$prop];
        })(...$args);
    }

    public static function propOr(...$args) {
        return _curry3(function($prop, $default, $obj) {
            return array_key_exists($prop, $obj) ? $obj[$prop] : $default;
        })(...$args);
    }

    public static function pick(...$args) {
        return _curry2(function($props, $obj) {
            $newObj = [];
            foreach ($props as $prop) {
                $newObj[$prop] = $obj[$prop];
            }

            return $newObj;
        })(...$args);
    }

    public static function uniq(...$args) {
        return _curry1(function($arr) {
            return array_values(array_unique($arr, SORT_REGULAR));
        })(...$args);
    }

    public static function merge($obj, ...$objs) {
        return empty($objs)
            ? function(...$objs) use ($obj) { return array_merge($obj, ...$objs); }
            : array_merge($obj, ...$objs);
    }

    public static function propEq(...$args) {
        return _curry3(function($prop, $value, $obj) {
            return $obj[$prop] === $value;
        })(...$args);
    }

    public static function propSatisfies(...$args) {
        return _curry3(function($fn, $prop, $obj) {
            return $fn($obj[$prop]) === true;
        })(...$args);
    }


    public static function pipe(...$fns) {
        return function ($identity) use ($fns) {
            return _reduce(function($acc, $fn) {
                return $fn($acc);
            }, $fns, $identity);
        };
    }

    public static function compose(...$fns) {
        return static::pipe(...array_reverse($fns));
    }

    public static function partial(...$args) {
        return _curry2(function($fn, $args) {
            return function() use ($fn, $args) {
                return call_user_func_array($fn, array_merge($args, func_get_args()));
            };
        })(...$args);
    }

    public static function not(...$args) {
        return _curry1(function($a) {
            return !$a;
        })(...$args);
    }

}
