<?php

namespace boehm_s;

class F {

    const _ = '@@fun-php/placeholder';

    private static function isPlaceholder($str) {
        return $str === static::_;
    }

    private static function _curry1($fn) {
        return function ($a = null) use ($fn) {
        	$args = func_get_args();
            return count($args) === 0 || static::isPlaceholder($a)? $fn : call_user_func_array($fn, $args);
        };
    }

    private static function _curry2($fn) {
        return function($a = null, $b = null) use ($fn) {
        	$args = func_get_args();
            switch (count($args)) {
            case 0:
                return $fn;
            case 1:
                return static::isPlaceholder($a) ? $fn : static::_curry1(function ($_b) use ($fn, $a) {
                    return $fn($a, $_b);
                });
            default:
                if (static::isPlaceholder($a) && static::isPlaceholder($b)) {
                    return $fn;
                } else if (static::isPlaceholder($a)) {
                    return static::_curry1(function ($_a) use($fn, $b) {
                        return $fn($_a, $b);
                    });
                } else if(static::isPlaceholder($b)) {
                    return static::_curry1(function ($_b) use($fn, $a) {
                        return $fn($a, $_b);
                    });
                } else {
                    return $fn($a, $b);
                }
            }
        };
    }

    private static function _curry3($fn) {
        return function($a = null, $b = null, $c = null) use ($fn) {
        	$args = func_get_args();
            switch (count($args)) {
            case 0:
                return $fn;
            case 1:
                return static::isPlaceholder($a) ? $fn : static::_curry2(function ($_b, $_c) use ($fn, $a) {
                    return $fn($a, $_b, $_c);
                });
            case 2:
                if (static::isPlaceholder($a) && static::isPlaceholder($b)) {
                    return $fn;
                } else {
                    if (static::isPlaceholder($a)) {
                        return static::_curry2(function ($_a, $_c) use ($fn, $b) {
                            return $fn($_a, $b, $_c);
                        });
                    } else if (static::isPlaceholder($b)) {
                        return static::_curry2(function ($_b, $_c) use ($fn, $a) {
                            return $fn($a, $_b, $_c);
                        });
                    } else {
                        return static::_curry1(function ($_c) use ($fn, $a, $b) {
                            return $fn($a, $b, $_c);
                        });
                    }
                }
            default:
                if (static::isPlaceholder($a) && static::isPlaceholder($b) && static::isPlaceholder($c)) {
                    return $fn;
                } else {
                    if (static::isPlaceholder($a) && static::isPlaceholder($b)) {
                        return static::_curry2(function ($_a, $_b) use ($fn, $c) {
                            return $fn($_a, $_b, $c);
                        });
                    } else if (static::isPlaceholder($a) && static::isPlaceholder($c)) {
                        return static::_curry2(function ($_a, $_c) use($fn, $b) {
                            return $fn($_a, $b, $_c);
                        });
                    } else if (static::isPlaceholder($b) && static::isPlaceholder($c)) {
                        return static::_curry2(function ($_b, $_c) use($fn, $a) {
                            return $fn($a, $_b, $_c);
                        });
                    } else if (static::isPlaceholder($a)) {
                        return static::_curry1(function ($_a) use($fn, $b, $c) {
                            return $fn($_a, $b, $c);
                        });
                    } else if (static::isPlaceholder($b)) {
                        return static::_curry1(function ($_b) use($fn, $a, $c) {
                            return $fn($a, $_b, $c);
                        });
                    } else if (static::isPlaceholder($c)) {
                        return static::_curry1(function ($_c) use($fn, $a, $b) {
                            return $fn($a, $b, $_c);
                        });
                    } else {
                        return $fn($a, $b, $c);
                    }
                }
            }
        };
    }

    public static function filter(...$args) {
        return static::_curry2(function($fn, $array) {
            return array_values(array_filter($array, $fn, ARRAY_FILTER_USE_BOTH));
        })(...$args);
    }

    public static function each(...$args) {
        return static::_curry2(function($fn, $array) {
            foreach ($array as $key => $value) {
                $fn($value, $key, $array);
            }
        })(...$args);
    }

    public static function map(...$args) {
        return static::_curry2(function($fn, $array) {
            return array_map($fn, $array);
        })(...$args);
    }

    public static function flatMap(...$args) {
        return static::_curry2(function($fn, $array) {
            $results = array_map($fn, $array);

            return empty($results) ? [] : array_merge(...$results);
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

    public static function propOr(...$args) {
        return static::_curry3(function($prop, $default, $obj) {
            return array_key_exists($prop, $obj) ? $obj[$prop] : $default;
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

    public static function uniq(...$args) {
        return static::_curry1(function($arr) {
            return array_values(array_unique($arr, SORT_REGULAR));
        })(...$args);
    }

    public static function merge($obj, ...$objs) {
        return empty($objs)
            ? function(...$objs) use ($obj) { return array_merge($obj, ...$objs); }
            : array_merge($obj, ...$objs);
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


    public static function pipe(...$fns) {
        return function ($x) use ($fns) {
            return array_reduce($fns, function($acc, $fn) {
                return $fn($acc);
            }, $x);
        };
    }

    public static function compose(...$fns) {
        return static::pipe(...array_reverse($fns));
    }

    public static function partial(...$args) {
        return static::_curry2(function($fn, $args) {
            return function() use ($fn, $args) {
                return call_user_func_array($fn, array_merge($args, func_get_args()));
            };
        })(...$args);
    }

    public static function not(...$args) {
        return static::_curry1(function($a) {
            return !$a;
        })(...$args);
    }
}
