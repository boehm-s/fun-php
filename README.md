# F.php

Functional programming utilities for PHP !
Inspired by JS Array methods, Ramda, underscore and many others ... 

# Example 

Sample data : 

```
$travel = [
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
```

Get all users names 

```
$get_all_users_names = F::pipe(
    F::prop('items'),
    F::flatMap(F::prop('users')),
    F::map(F::prop('name')),
    F::uniq()
);

$travels_users = $get_all_users_names($travel);

var_dump($travels_users);  //  ["Jimmy Page", "Roy Harper", "Robert Plant", "John Paul Jones", "John Bonham"]
```
