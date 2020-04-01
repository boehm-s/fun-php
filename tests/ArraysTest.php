<?php

use PHPUnit\Framework\TestCase;
use boehm_s\F;

final class ArraysTest extends TestCase
{
    private $numArray10 = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
    private $numArray5 = [1, 2, 3, 4, 5];
    private $numArray5Nested = [[1, 2], [3, 4], [5]];

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

        $curriedDoubles = F::flatMap(function($n) { return [$n, $n]; });
        $doubles = $curriedDoubles($this->numArray5);

        $this->assertEquals($doubles, [1, 1, 2, 2, 3, 3, 4, 4, 5, 5]);
    }

    public function testFind(): void
    {
        $moreThan5 = function($n) { return $n > 5; };
        $fifth = function($_n, $i) { return $i === 4; };
        $findFifth = F::find($fifth);

        $this->assertEquals(F::find($moreThan5, $this->numArray10), 6);
        $this->assertEquals($findFifth($this->numArray10), 5);
    }

    public function testFindIndex(): void
    {
        $moreThan5 = function($n) { return $n > 5; };
        $fifth = function($_n, $i) { return $i === 4; };
        $findFifth = F::findIndex($fifth);

        $this->assertEquals(F::findIndex($moreThan5, $this->numArray10), 5);
        $this->assertEquals($findFifth($this->numArray10), 4);
    }

    public function testSome(): void
    {
        $moreThan5 = function($n) { return $n > 5; };
        $this->assertEquals(F::some($moreThan5, $this->numArray10), true);
        $this->assertEquals(F::some($moreThan5, $this->numArray5), false);

    }

    public function testEvery(): void
    {
        $moreThan5 = function($n) { return $n > 5; };
        $positiveIndex = function($_n, $i) { return $i >= 0; };
        $allPositiveIndex = F::every($positiveIndex);

        $this->assertEquals(F::every($moreThan5, $this->numArray10), false);
        $this->assertEquals($allPositiveIndex($this->numArray5), true);
    }

    public function testSort(): void
    {
        $asc = function($a, $b) { return $a - $b; };
        $array = [3, 5, 1, 4, 2];

        $this->assertEquals(F::sort($asc, $array), $this->numArray5);
        $this->assertEquals($array,  [3, 5, 1, 4, 2]);
    }

    public function testReduce(): void
    {
        $sum = function($acc, $val) { return $acc + $val; };
        $sumNumbers = F::reduce($sum, 0);

        $this->assertEquals($sumNumbers($this->numArray5), 15);
    }

    public function testIncludes(): void
    {
        $this->assertEquals(F::includes(4, $this->numArray5), true);
        $this->assertEquals(F::includes(10, $this->numArray5), false);
        $this->assertEquals(F::includes(3)($this->numArray5), true);

        $test = F::filter(F::includes(3))($this->numArray5Nested);
        $this->assertEquals($test, [[3, 4]]);
    }

    public function testReverse(): void
    {
        $reversed5 = F::reverse($this->numArray5);
        $this->assertEquals($reversed5, [5, 4, 3, 2, 1]);
        $this->assertEquals($this->numArray5, [1, 2, 3, 4, 5]);
    }
}
