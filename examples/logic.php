<?php

use boehm_s\F;

//! [not]
F::not(true); //=> false
F::not(false); //=> true
F::not('Punky'); //=> false
//! [not]
