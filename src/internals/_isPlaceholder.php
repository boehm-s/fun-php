<?php

use boehm_s\F;

function _isPlaceholder($str) {
    return $str === F::_;
}
