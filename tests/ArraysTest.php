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
        $this->assertEquals([2, 4, 6, 8, 10], $even);

        $curried = F::filter($isEven);
        $this->assertIsCallable($curried);

        $even = $curried($this->numArray10);
        $this->assertEquals([2, 4, 6, 8, 10], $even);

        /* Check if the array has been re-indexed */
        $keys = array_keys($even);
        $this->assertEquals([0, 1, 2, 3, 4], $keys);

        /* Check if indexes are also passed to the predicate function */
        $first5 = F::filter(function($_n, $i) { return $i < 5; }, $this->numArray10);
        $this->assertEquals($this->numArray5, $first5);
    }

    public function testMap(): void
    {
        $square = function($n) { return $n * $n; };
        $squared = F::map($square, $this->numArray5);
        $this->assertEquals([1, 4, 9, 16, 25], $squared);

        $curried = F::map($square);
        $this->assertIsCallable($curried);

        $squared = $curried($this->numArray5);
        $this->assertEquals([1, 4, 9, 16, 25], $squared);
    }

    public function testEach(): void
    {
        $square = function($n) { return $n * $n; };
        $not_squared = F::each($square, $this->numArray5);
        $this->assertEquals($not_squared, $this->numArray5);

        $i = 0;
        $curried = F::each(function($_) use (&$i) { $i += 1; return 0; });
        $this->assertIsCallable($curried);

        $not_squared = $curried($this->numArray5);
        $this->assertEquals($not_squared, $this->numArray5);
        $this->assertEquals($i, 5);

    }

    public function testFlatMap(): void
    {
        $flatten = F::flatMap(function($n) { return $n; }, $this->numArray5Nested);
        $this->assertEquals($this->numArray5, $flatten);

        $curriedDoubles = F::flatMap(function($n) { return [$n, $n]; });
        $doubles = $curriedDoubles($this->numArray5);

        $this->assertEquals([1, 1, 2, 2, 3, 3, 4, 4, 5, 5], $doubles);

        $nothing = F::flatMap(function ($x) { return $x; }, []);

        $this->assertEquals([], $nothing);

        $flatEmpty = F::flatMap(function ($_x) { return []; }, $this->numArray5);

        $this->assertEquals([], $flatEmpty);
}

    public function testFind(): void
    {
        $moreThan5 = function($n) { return $n > 5; };
        $fifth = function($_n, $i) { return $i === 4; };
        $findFifth = F::find($fifth);

        $this->assertEquals(6, F::find($moreThan5, $this->numArray10));
        $this->assertEquals(5, $findFifth($this->numArray10));

        $tenth = function($_n, $i) { return $i === 9; };
        $this->assertEquals(null, F::find($tenth, $this->numArray5));
    }

    public function testFindIndex(): void
    {
        $moreThan5 = function($n) { return $n > 5; };
        $fifth = function($_n, $i) { return $i === 4; };
        $findFifth = F::findIndex($fifth);

        $this->assertEquals(5, F::findIndex($moreThan5, $this->numArray10));
        $this->assertEquals(4, $findFifth($this->numArray10));

        $tenth = function($_n, $i) { return $i === 9; };
        $this->assertEquals(null, F::findIndex($tenth, $this->numArray5));
    }

    public function testSome(): void
    {
        $moreThan5 = function($n) { return $n > 5; };
        $this->assertEquals(true, F::some($moreThan5, $this->numArray10));
        $this->assertEquals(false, F::some($moreThan5, $this->numArray5));

    }

    public function testEvery(): void
    {
        $moreThan5 = function($n) { return $n > 5; };
        $positiveIndex = function($_n, $i) { return $i >= 0; };
        $allPositiveIndex = F::every($positiveIndex);

        $this->assertEquals(false, F::every($moreThan5, $this->numArray10));
        $this->assertEquals(true, $allPositiveIndex($this->numArray5));
    }

    public function testSort(): void
    {
        $asc = function($a, $b) { return $a - $b; };
        $array = [3, 5, 1, 4, 2];

        $this->assertEquals($this->numArray5, F::sort($asc, $array));
        $this->assertEquals([3, 5, 1, 4, 2], $array);
    }

    public function testReduce(): void
    {
        $sum = function($acc, $val) { return $acc + $val; };
        $sumNumbers = F::reduce($sum, 0);

        $this->assertEquals(15, $sumNumbers($this->numArray5));
    }

    public function testIncludes(): void
    {
        $this->assertEquals(true, F::includes(4, $this->numArray5));
        $this->assertEquals(false, F::includes(10, $this->numArray5));
        $this->assertEquals(true, F::includes(3)($this->numArray5));

        $test = F::filter(F::includes(3))($this->numArray5Nested);
        $this->assertEquals([[3, 4]], $test);
    }

    public function testReverse(): void
    {
        $reversed5 = F::reverse($this->numArray5);
        $this->assertEquals([5, 4, 3, 2, 1], $reversed5);
        $this->assertEquals([1, 2, 3, 4, 5], $this->numArray5);
    }

    public function testUniq(): void
    {
        $array = [1, 2, 4, 2, 5, 1, 3];
        $expected = [1, 2, 4, 5, 3];
        $actual = F::uniq($array);
        $this->assertEquals($expected, $actual);
    }
}
