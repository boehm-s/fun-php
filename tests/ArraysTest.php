<?php

use PHPUnit\Framework\TestCase;
use boehm_s\F;

final class ArrayTest extends TestCase
{
    private $numArray = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

    public function testFilter(): void
    {
        $isEven = function($n) { return $n % 2 == 0; };
        $even = F::filter($isEven, $this->numArray);
        $this->assertEquals($even, [2, 4, 6, 8, 10]);

        $curried = F::filter($isEven);
        $this->assertIsCallable($curried);

        $even = $curried($this->numArray);
        $this->assertEquals($even, [2, 4, 6, 8, 10]);

        /* Check if the array has been re-indexed */
        $keys = array_keys($even);
        $this->assertEquals($keys, [0, 1, 2, 3, 4]);
    }
}
