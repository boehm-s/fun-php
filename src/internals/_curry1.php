<?php

require_once(realpath(dirname(__FILE__) . '/_isPlaceholder.php'));

function _curry1($fn) {
    return function ($a = null) use ($fn) {
        $args = func_get_args();
        if (count($args) === 0 || _isPlaceholder($a)) {
            return function(...$args) use ($fn) { return _curry1($fn)(...$args); };
        } else {
            return call_user_func_array($fn, $args);
        }
    };
}
