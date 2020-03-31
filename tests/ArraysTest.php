<?php

use PHPUnit\Framework\TestCase;
use boehm_s\F;

final class ArrayTest extends TestCase
{
    private $numArray10 = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
    private $numArray5 = [1, 2, 3, 4, 5];
    private $numArray5Nested = [[1, 2], [3, 4], 5];

    public function testFilter(): void
    {
        $isEven = function($n) { return $n % 2 == 0; };
        $even = F::filter($isEven, $this->numArray10);
        $this->assertEquals($even, [2, 4, 6, 8, 10]);

        $curried = F::filter($isEven);
        $this->assertIsCallable($curried);

        $even = $curried($this->numArray10);
        $this->assertEquals($even, [2, 4, 6, 8, 10]);

        /* Check if the array has been re-indexed */
        $keys = array_keys($even);
        $this->assertEquals($keys, [0, 1, 2, 3, 4]);

        /* Check if indexes are also passed to the predicate function */
        $first5 = F::filter(function($_n, $i) { return $i < 5; }, $this->numArray10);
        $this->assertEquals($first5, $this->numArray5);
    }

    public function testMap(): void
    {
        $square = function($n) { return $n * $n; };
        $squared = F::map($square, $this->numArray5);
        $this->assertEquals($squared, [1, 4, 9, 16, 25]);

        $curried = F::map($square);
        $this->assertIsCallable($curried);

        $squared = $curried($this->numArray5);
        $this->assertEquals($squared, [1, 4, 9, 16, 25]);
    }

    public function testFlatMap(): void
    {
        $flatten = F::flatMap(function($n) { return $n; }, $this->numArray5Nested);
        $this->assertEquals($flatten, $this->numArray5);
    }


}
