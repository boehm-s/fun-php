<?php
/**
 * fun-php | Bringing FP th PHP
 *
 * @package boehm_s\fun-php
 * @author  Steven BOEHM <steven.boehm.dev@gmail.com>
 * @version v1.2.1 (18/08/2020)
 */

namespace boehm_s;

require_once(realpath(dirname(__FILE__) . '/internals/_curry1.php'));
require_once(realpath(dirname(__FILE__) . '/internals/_curry2.php'));
require_once(realpath(dirname(__FILE__) . '/internals/_curry3.php'));
require_once(realpath(dirname(__FILE__) . '/internals/_isPlaceholder.php'));
require_once(realpath(dirname(__FILE__) . '/internals/_filter.php'));
require_once(realpath(dirname(__FILE__) . '/internals/_map.php'));
require_once(realpath(dirname(__FILE__) . '/internals/_reduce.php'));

/**
 * Class F - fun.php
 *
 * Contains all the methods to be used
 */
class F {
    const _ = '@@fun-php/placeholder';

    /**
     * Takes a predicate and a `iterable` and returns an array containing the members
     * of the given iterable which satisfy the given predicate.
     *
     * @param callable $predicate
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
     * Returns the original array.
     *
     * @param callable $fn
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
     * @param callable $fn
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
     * @param callable $fn
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
     * @param callable $predicate
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
     * @param callable $predicate
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

    /**
     * Takes a predicate and a `iterable` and returns true if one of the
     * iterable members satisfies the predicate.
     *
     * @param callable $predicate
     * @param iterable $arr
     * @return bool
     */
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

    /**
     * Takes a predicate and a `iterable` and returns true if all of the
     * iterable members satisfies the predicate.
     *
     * @param callable $predicate
     * @param iterable $arr
     * @return bool
     */
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

    /**
     * Takes a comparison function and an array (NO OBJECTS) and return a copy of the array
     * sorted according to the comparison function.
     *
     * @param callable $fn
     * @param array $arr
     * @return array
     */
    public static function sort(...$args) {
        return _curry2(function($fn, $array) {
            $copiedArray = $array;
            usort($copiedArray, $fn);
            return $copiedArray;

        })(...$args);
    }

    /**
     * Takes an array (NO OBJECTS) and returns a reversed copy of the array.
     *
     * @param array $arr
     * @return array
     */
    public static function reverse(...$args) {
        return _curry1(function($array) {
            $copiedArray = $array;

            return array_reverse($copiedArray);
        })(...$args);
    }

    /**
     * Takes an iterable, a function and a starting (or default) value. Reduces the iterable to a single
     * value by successively calling the function, passing it an accumulator value and the current value
     * from the iterable, and then passing the result to the next call.
     *
     * @param callable $fn
     * @param mixed $arr
     * @param iterable $arr
     * @return mixed
     */
    public static function reduce(...$args) {
        return _curry3(function($fn, $default, $array) {
            return _reduce($fn, $array, $default);
        })(...$args);
    }

    /**
     * Takes a value and an array. Returns true if the value is in the array and false otherwise.
     *
     * @param mixed $needle
     * @param array $haystack
     * @return bool
     */
    public static function includes(...$args) {
        return _curry2(function($value, $array) {
            return in_array($value, $array);
        })(...$args);
    }


    /**
     * Takes a property and an array and returns the array's property value.
     *
     * @param string | int $prop
     * @param array $array
     * @return mixed
     */
    public static function prop(...$args) {
        return _curry2(function($prop, $obj) {
            return $obj[$prop];
        })(...$args);
    }

    /**
     * Takes a property, an array and a default value. Returns the array's property value if it
     * exists and the default value otherwise.
     *
     * @param string | int $prop
     * @param mixed $default
     * @param array $array
     * @return mixed
     */
    public static function propOr(...$args) {
        return _curry3(function($prop, $default, $obj) {
            return array_key_exists($prop, $obj) ? $obj[$prop] : $default;
        })(...$args);
    }

    /**
     * Takes a list of properties and an (associative) array. Returns a partial copy of the
     * (associative) array containing only the keys specified.
     *
     * @param array $props
     * @param array $array
     * @return array
     */
    public static function pick(...$args) {
        return _curry2(function($props, $obj) {
            $newObj = [];
            foreach ($props as $prop) {
                $newObj[$prop] = $obj[$prop];
            }

            return $newObj;
        })(...$args);
    }

    /**
     * Takes an array and returns a new array containing only one copy of each element in the original one.
     * Warning : re-indexes the array.
     *
     * @param array $array
     * @return array
     */
    public static function uniq(...$args) {
        return _curry1(function($arr) {
            return array_values(array_unique($arr, SORT_REGULAR));
        })(...$args);
    }

    /**
     * Takes an (associative) array and at leat one other (variadic on the second argument) and returns
     * all these arrays merged together.
     *
     * @param array $array1
     * @param array[] ...$array2
     * @return array
     */
    public static function merge($obj, ...$objs) {
        return empty($objs)
            ? function(...$objs) use ($obj) { return array_merge($obj, ...$objs); }
            : array_merge($obj, ...$objs);
    }

    /**
     * Takes a property, a value and an (associative) array. Returns true if the specified array property is
     * equal to the supplied value and false otherwise.
     *
     * @param string $prop
     * @param mixed $value
     * @param array $array
     * @return bool
     */
    public static function propEq(...$args) {
        return _curry3(function($prop, $value, $obj) {
            return $obj[$prop] === $value;
        })(...$args);
    }

    /**
     * Takes a predicate, a property and an (associative) array. Returns true if the specified array property
     * matches the predicate and false otherwise.
     *
     * @param callable $predicate
     * @param mixed $prop
     * @param array $array
     * @return bool
     */
    public static function propSatisfies(...$args) {
        return _curry3(function($fn, $prop, $obj) {
            return $fn($obj[$prop]) === true;
        })(...$args);
    }

    /**
     * Performs left-to-right function composition. Like the unix pipe (|). All the function must be unary.
     *
     * @param callable[] ...$fns
     * @return callable
     */
    public static function pipe(...$fns) {
        return function ($identity) use ($fns) {
            return _reduce(function($acc, $fn) {
                return $fn($acc);
            }, $fns, $identity);
        };
    }

    /**
     * Performs right-to-left function composition. Like the unix pipe (|). All the function must be unary.
     *
     * @param callable[] ...$fns
     * @return callable
     */
    public static function compose(...$fns) {
        return static::pipe(...array_reverse($fns));
    }

    /**
     * Takes a function and an array of arguments. Applies the arguments to the function and returns a new
     * function awaiting the rest of the arguments.
     *
     * @param callable $fn
     * @param array $args
     * @return callable
     */
    public static function partial(...$args) {
        return _curry2(function($fn, $args) {
            return function() use ($fn, $args) {
                return call_user_func_array($fn, array_merge($args, func_get_args()));
            };
        })(...$args);
    }

    /**
     * Takes a value and returns the it's `!` (NOT Logical operator). Returns true when passed a falsy value, and false when passed a truthy one.
     *
     * @param mixed $value
     * @return bool
     */
    public static function not(...$args) {
        return _curry1(function($a) {
            return !$a;
        })(...$args);
    }

}
