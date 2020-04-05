<?php

use PHPUnit\Framework\TestCase;
use boehm_s\F;

final class CompositionTest extends TestCase
{
    private $users = [
        [
            'id' => 1,
            'name' => 'Dupont',
            'firstname' => 'Marc',
            'email' => 'marc.dupont@gmail.com',
            'follow_ids' => [2, 4]
        ],
        [
            'id' => 2,
            'name' => 'Durand',
            'firstname' => 'Pierre',
            'email' => 'pierre.durand@gmail.com',
            'follow_ids' => [1, 4]
        ],
        [
            'id' => 3,
            'name' => 'Plant',
            'firstname' => 'Robert',
            'email' => 'robert.plant@gmail.com',
            'follow_ids' => [2, 4]
        ],
        [
            'id' => 4,
            'name' => 'Page',
            'firstname' => 'Jimmy',
            'email' => 'robert.plant@gmail.com',
            'follow_ids' => [3]
        ],
    ];


    public function testCompose(): void
    {
        $ledzep_ids = [3, 4];
        $yellLedZepNames = F::compose(
            F::map('strtoupper'),
            F::map(F::prop('name')),
            F::filter(function($user) use ($ledzep_ids) {
                return in_array($user['id'], $ledzep_ids);
            })
        );

        $result = $yellLedZepNames($this->users);
        $expected = ['PLANT', 'PAGE'];
        $this->assertEquals($expected, $result);

    }

    public function testPipe(): void
    {
        $getUsersFullNames = F::pipe(
            F::map(F::pick(['firstname', 'name'])),
            F::map(function($o) { return $o['firstname'] . ' ' . $o['name']; })
        );

        $result = $getUsersFullNames($this->users);
        $expected = ['Marc Dupont', 'Pierre Durand', 'Robert Plant', 'Jimmy Page'];
        $this->assertEquals($expected, $result);
    }
}
