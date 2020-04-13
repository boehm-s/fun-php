<?php

use PHPUnit\Framework\TestCase;
use boehm_s\F;

final class PlaceholderTest extends TestCase
{
    private $numArray10 = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

    public function testBasicBehavior(): void
    {
        $filterNum10 = F::filter(F::_, $this->numArray10);
        $isEven = function($n) { return $n % 2 == 0; };

        $even = F::filter($isEven, $this->numArray10);

        $this->assertEquals($even, $filterNum10($isEven));
    }

    public function testFnEquals(): void
    {
        $filter = F::filter(F::_, F::_);
        $this->assertEquals(F::filter(), $filter);
    }
}
