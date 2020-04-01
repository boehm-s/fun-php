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
        $this->assertEquals($getKey1($this->obj1), 5);
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
        // TODO
    }

    public function testPropSatisfies(): void
    {
        // TODO
    }
}
