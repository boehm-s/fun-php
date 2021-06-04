<?php
/**
 * @brief fun-php | Bringing FP to PHP
 * @file fun.php
 * @author  Steven BOEHM <steven.boehm.dev@gmail.com>
 * @package boehm_s\fun-php
 * @version v1.2.2
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
 * This class contains all the methods of the fun-php library.
 * These "methods" are all static, so these are just functions.
 */
class F {


    /**
     * @brief `F::_` is a special placeholder value used to specify "gaps" within curried functions,
     *        allowing partial application of any combination of arguments, regardless of their positions.
     *
     *        If g is a curried ternary function and `_` is `F::_`, the following are equivalent:
     *
     * @code _ @endcode
     *
     * @code
     *    g(1, 2, 3);
     *    g(_, 2, 3)(1)
     *    g(_, _, 3)(1)(2);
     *    g(_, 2, _)(1, 3);
     *    g(_, 2)(1)(3);
     *    g(_, 2)(1, 3);
     *    g(_, 2)(_, 3)(1);
     * @endcode
     */
    const _ = '@@fun-php/placeholder';


    /**
     * Takes a predicate and a iterable and returns an array containing the members
     * of the given iterable which satisfy the given predicate.
     *
     * @code ((a, i, [a]) → Bool) → [a] → [a] @endcode
     * @snippet lists.php filter
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
     * Takes a predicate and a list and returns the pair of elements which do and do not satisfy
     * the predicate, respectively.
     *
     * @code ((a, i, [a]) → Bool) → [a] → [[a], [a]] @endcode
     * @snippet lists.php partition
     *
     * @param callable $predicate
     * @param iterable $arr
     * @return array
     */
    public static function partition(...$args) {
        return _curry2(function($fn, $array) {
            return _partition($fn, $array);
        })(...$args);
    }

    /**
     * Iterate over an iterable, calling a provided function $fn for each element.
     * Returns the original array.
     *
     * @code (a → *) → [a] → [a] @endcode
     * @snippet lists.php each
     *
     * @param callable $fn
     * @param iterable $arr
     * @return iterable
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
     * Takes a function and a iterable and returns an array containing the results
     * of function applied to each iterable values.
     *
     * @code ((a, i, [a]) → b) → [a] → [b] @endcode
     * @snippet lists.php map
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
     * Takes a function and a iterable, apply the function to each of the iterable
     * value and then flatten the result.
     *
     * @code ((a, i, [a]) → [b]) → [a] → [b] @endcode
     * @snippet lists.php flatMap
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
     * @code ((a, i, [a]) → Bool) → [a] → a @endcode
     * @snippet lists.php find
     *
     * @template T
     * @param callable $predicate
     * @param iterable<T> $arr
     * @return T
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
     * @code ((a, i, [a]) → Bool) → [a] → i @endcode
     * @snippet lists.php findIndex
     *
     * @param callable $predicate
     * @param iterable $arr
     * @return int | string
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
     * Takes a predicate and a iterable and returns true if one of the
     * iterable members satisfies the predicate.
     *
     * @code ((a, i, [a]) → Bool) → [a] → Bool @endcode
     * @snippet lists.php some
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
     * Takes a predicate and a iterable and returns true if all of the
     * iterable members satisfies the predicate.
     *
     * @code ((a, i, [a]) → Bool) → [a] → Bool @endcode
     * @snippet lists.php every
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
     * @code ((a, a) → Bool) → [a] → [a] @endcode
     * @snippet lists.php sort
     *
     * @param callable $fn
     * @param array $arr
     * @return array
     */
    public static function sort(...$args) {
        return _curry2(function($fn, $array) {
            usort($array, $fn);
            return $array;

        })(...$args);
    }

    /**
     * Takes an array (NO OBJECTS) and returns a reversed copy of the array.
     *
     * @code [a] → [a] @endcode
     * @snippet lists.php reverse
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
     * @code ((a, b) → a) → a → [b] → a @endcode
     * @snippet lists.php reduce
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
     * @code a → [a] → Bool @endcode
     * @snippet lists.php includes
     *
     * @param mixed $needle
     * @param array $haystack
     * @return bool
     */
    public static function includes(...$args) { // TODO: make it work with strings
        return _curry2(function($value, $array) {
            return in_array($value, $array);
        })(...$args);
    }


    /**
     * Takes a property and an array and returns the array's property value.
     *
     * @code k → {k: v} → v | null @endcode
     * @snippet assoc.php prop
     *
     * @param string | int $prop
     * @param array $array
     * @return mixed
     */
    public static function prop(...$args) {
        return _curry2(function($prop, $arr) {
            return $arr[$prop];
        })(...$args);
    }

    /**
     * Acts as multiple `prop` array of keys in, array of values out. Preserves order.
     *
     * @code [k] → {k: v} → [v] @endcode
     * @snippet assoc.php props
     *
     * @param array $props
     * @param array $array
     * @return array
     */
    public static function props(...$args) {
        return _curry2(function($props, $arr) {
            $res = [];

            foreach ($props as $prop) {
                $res[] = $arr[$prop] ?? null;
            }

            return $res;
        })(...$args);
    }


    /**
     * Takes a property, an array and a default value. Returns the array's property value if it
     * exists and the default value otherwise.
     *
     * @code k → d → {k: v} → v | d @endcode
     * @snippet assoc.php propOr
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
     * @code [k] → {k: v} → {k: v} | null @endcode
     * @snippet assoc.php pick
     *
     * @param array $props
     * @param array $array
     * @return array
     */
    public static function pick(...$args) {
        return _curry2(function($props, $obj) {
            $newObj = [];
            foreach ($props as $prop) {
                if (isset($obj[$prop])) {
                    $newObj[$prop] = $obj[$prop];
                }
            }

            return $newObj;
        })(...$args);
    }

    /**
     * Takes an array and returns a new array containing only one copy of each element in the original one.
     * Warning : re-indexes the array.
     *
     * @code [a] → [a] @endcode
     * @snippet lists.php uniq
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
     * Returns a new list containing only one copy of each element in the original list, based upon the value
     * returned by applying the supplied function to each list element. Prefers the first item if the supplied
     * function produces the same value on two items.
     *
     * @code (a → b) → [a] → [a] @endcode
     * @snippet lists.php uniqBy
     *
     * @param callable $fn
     * @param array $array
     * @return array
     */
    public static function uniqBy(...$args) {
        return _curry2(function($fn, $array) {
            $set         = [];
            $result      = [];

            foreach ($array as $item) {
                $appliedItem = $fn($item);
                if (!in_array($appliedItem, $set)) {
                    $set[]    = $appliedItem;
                    $result[] = $item;
                }
            }

            return $result;
        })(...$args);
    }

    /**
     * Splits a given list at a given index.
     *
     * @code Number → [a] → [[a], [a]] @endcode
     * @snippet lists.php splitAt
     *
     * @param int $fn
     * @param array $array
     * @return array
     */
    public static function splitAt(...$args) {
        return _curry2(function($idx, $list) {
            $len = count($list);
            $fst = $snd = [];

            for ($i = 0; $i < $len; ++$i) {
                if ($i < $idx) {
                    $fst[] = $list[$i];
                } else {
                    $snd[] = $list[$i];
                }
            }

            return [$fst, $snd];
        })(...$args);
    }



    /**
     * Takes an (associative) array and at least one other (variadic on the second argument) and returns
     * all these arrays merged together.
     *
     * @code {k: v} → ({k: v}, ..., {k: v}) → {k: v} @endcode
     * @snippet assoc.php merge
     *
     * @param array $array1
     * @param array ...$array2
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
     * @code k → v → {k: v} → Bool @endcode
     * @snippet assoc.php propEq
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
     * @code (v → Bool) → k → {k: v} → Bool @endcode
     * @snippet assoc.php propSatisfies
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
     * @code ((a → b), (b → c), ... , (y → z)) → (a → z) @endcode
     * @snippet func.php pipe
     *
     * @param callable ...$fns
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
     * Performs right-to-left function composition. Like the unix pipe (|), but reversed ! All the function must be unary.
     *
     * @code ((y → z), (x → y), ... ,(a → b)) → (a → z) @endcode
     * @snippet func.php compose
     *
     * @param callable ...$fns
     * @return callable
     */
    public static function compose(...$fns) {
        return static::pipe(...array_reverse($fns));
    }

    /**
     * Takes a function and an array of arguments. Applies the arguments to the function and returns a new
     * function awaiting the rest of the arguments.
     *
     * @code ((a, b, ..., n) → x) → [a, b, ...] → ((d, e, ..., n) → x) @endcode
     * @snippet func.php partial
     *
     * @param callable $fn
     * @param array $args
     * @return callable
     */
    public static function partial(...$args) {
        return _curry2(function($fn, $params) {
            return function(...$rest_params) use ($fn, $params) {
                return call_user_func_array($fn, array_merge($params, $rest_params));
            };
        })(...$args);
    }

    /**
     * Takes a value and returns the it's `!` (NOT Logical operator). Returns true when passed a falsy value, and false when passed a truthy one.
     *
     * @code * → Bool @endcode
     * @snippet logic.php not
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
