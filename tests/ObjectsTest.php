<?php

use PHPUnit\Framework\TestCase;
use boehm_s\F;

final class ObjectsTest extends TestCase
{
    private $obj1 = [
        'key1' => 5,
        'key2' => 42,
        'key3' => 256,
        'key4' => 1024,
    ];

    private $obj2 = [
        'key1' => [2, 5, 6, 8, 1, 78, 168],
        'key2' => [21, 52, 63, 8, 1, 7, 18],
        'key3' => [8, 14, 784, 156],
    ];

    public function testProp(): void
    {
        $getKey1 = F::prop('key1');

        $this->assertIsCallable($getKey1);
        $this->assertEquals(5, $getKey1($this->obj1));
    }

    public function testProps(): void
    {
        $getKey1and2 = F::props(['key1', 'key2']);

        $this->assertIsCallable($getKey1and2);
        $this->assertEquals([5, 42], $getKey1and2($this->obj1));

        $this->assertEquals(
            [5, null],
            F::props(['key1', 'z'], $this->obj1)
        );
    }

    public function testPropOr(): void
    {
        $getKey42 = F::propOr('key42', []);
        $getKey1 = F::propOr('key1', []);

        $this->assertIsCallable($getKey42);
        $this->assertIsCallable($getKey1);
        $this->assertEquals(5, $getKey1($this->obj1));
        $this->assertEquals([], $getKey42($this->obj1));
    }

    public function testPick(): void
    {
        $pickKeys3and4 = F::pick(['key3', 'key4']);
        $this->assertIsCallable($pickKeys3and4);
        $this->assertEquals(
            $pickKeys3and4($this->obj1),
            ['key3' => 256, 'key4' => 1024]
        );
    }

    public function testPropEq(): void
    {
        $compareKey1 = F::propEq('key1');
        $key1Is5 = $compareKey1(5);
        $key2Is42 = F::propEq('key2', 42);

        $this->assertEquals(true, $key1Is5($this->obj1));
        $this->assertEquals(false, $key1Is5($this->obj2));
        $this->assertEquals(false, F::propEq('key2', 42, $this->obj2));
        $this->assertEquals(true, $key2Is42($this->obj1));
    }

    public function testPropSatisfies(): void
    {
        $elemIsArray = function($el) { return is_array($el); };
        $this->assertEquals(true, F::propSatisfies($elemIsArray, 'key1', $this->obj2));
        $this->assertEquals(false, F::propSatisfies($elemIsArray, 'key1', $this->obj1));

    }

    public function testMerge(): void
    {
        $a = [1];
        $b = [2];
        $c = ['c' => 3];
        $d = ['d' => 4];

        $mergeA = F::merge($a);
        $this->assertIsCallable($mergeA);
        $this->assertEquals([1, 2], $mergeA($b));

        $abc = F::merge($a, $b, $c);
        $this->assertEquals([1, 2, 'c' => 3], $abc);
        $this->assertEquals([1, 2, 'c' => 3], $mergeA($b, $c));
    }
}
