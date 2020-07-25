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

    private $travel = [
        "items" => [
            [
                "id" => 1,
                "type" => "train",
                "start" => "2020-04-23T12:04:00.000Z",
                "end" => "2020-04-23T14:08:00.000Z",
                "users" => [
                    [ "id" => 1, "name" => "Jimmy Page" ],
                    [ "id" => 5, "name" => "Roy Harper" ]
                ],
            ], [
                "id" => 421,
                type => "hotel",
                "start" => "2020-04-23T12:00:00.000Z",
                "end" => "2020-04-24T14:10:00.000Z",
                "users" => [
                    [ "id" => 1, "name" => "Jimmy Page" ],
                    [ "id" => 2, "name" => "Robert Plant" ]
                ],
            ], [
                "id" => 876,
                "type" => "flight",
                "start" => "2020-04-23T12:04:00.000Z",
                "end" => "2020-04-23T14:08:00.000Z",
                "users" => [
                    [ "id" => 3, "name" => "John Paul Jones" ],
                    [ "id" => 4, "name" => "John Bonham" ]
                ],
            ]
        ]
    ];

    private $jsonData = '
[{
    "id": 42,
    "title": "Another travel in the wall",
    "user_id": 45,
    "items": [
        { "type": 1,  "description": "Car travel item ..."},
        { "type": 2,  "description": "Hotel travel item ..."},
        { "type": 2,  "description": "Another Hotel ..."}
    ]
}, {
    "id": 43,
    "title": "This ain\'t the summer of travel",
    "user_id": 1360,
    "items": [
        { "type": 2,  "description": "Hotel travel item ..."},
        { "type": 3,  "description": "Flight travel item ..."}
    ]
}, {
    "id": 44,
    "title": "I\'d love to change the travel",
    "user_id": 45,
    "items": [
        { "type": 2,  "description": "First hotel of the travel ..."},
        { "type": 4,  "description": "Car travel item ..."},
        { "type": 2,  "description": "Hotel travel item ..."}
    ]
}]';

    public function testCompose(): void
    {
        $ledzep_ids = [3, 4];
        $yellLedZepNames = F::compose(
            F::map(F::toUpper()),
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

    public function testReadmeExample(): void
    {
        $get_all_users_names = F::pipe(
            F::prop('items'),
            F::flatMap(F::prop('users')),
            F::map(F::prop('name')),
            F::uniq()
        );

        $travels_users = $get_all_users_names($this->travel);

        $expected = ["Jimmy Page", "Roy Harper", "Robert Plant", "John Paul Jones", "John Bonham"];

        $this->assertEquals($expected, $travels_users);
    }

    public function testPartialApplication(): void
    {
        $add = function($a, $b) {
            return $a + $b;
        };

        $_add5 = function($b) {
            return 5 + $b;
        };

        $add5 = F::partial($add, [5]);

        $this->assertEquals($_add5, $add5);
        $this->assertEquals(15, $add5(10));
    }

    public function testMultipleDataProcessingBehaviors(): void
    {
        $travels = json_decode($this->jsonData, true);

        $type2Items = F::flatMap(function ($travel, $i) {
            return F::pipe(
                F::prop('items'),
                F::filter(F::propEq('type', 2)),
                F::map(F::merge(['travel_index' => $i])) // keep index for faster access later
            )($travel);
        }, $travels);

        $this->assertEquals(5, count($type2Items));

        echo "\n" . json_encode($type2Items, JSON_PRETTY_PRINT);
    }
}
