<?php

use PHPUnit\Framework\TestCase;
use boehm_s\F;

final class SpecialUseCaseTest extends TestCase
{
    private $numArray10 = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
    private $numArray5 = [1, 2, 3, 4, 5];
    private $numArray5Nested = [[1, 2], [3, 4], [5]];

    public static function plusOne($n)
    {
        return $n + 1;
    }

    public function testMap(): void
    {
        $res = F::map([static::class, 'plusOne'], $this->numArray5);
        $this->assertEquals([2, 3, 4, 5, 6], $res);
    }
}
