<?php

require_once(realpath(dirname(__FILE__) . '/_isPlaceholder.php'));

function _curry1($fn) {
    return function ($a = null) use ($fn) {
        $args = func_get_args();
        return count($args) === 0 || _isPlaceholder($a)? $fn : call_user_func_array($fn, $args);
    };
}
