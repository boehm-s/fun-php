# fun-php

**fun**ctional programming utilities for PHP !

Inspired by Javascript, Ramda, lodash and many other things !

# Installation 




# How to use it ?

You can use it just like Ramda, in fact you can even rely on the excellent [Ramda documentation!](https://ramdajs.com/docs/) !

As with Ramda, fun-php methods are automatically curried : 

```
F::map($fn, $array)  <==>  F::map($fn)($array)  <==>  F::map()($fn)($array)
```

## Implemented methods

### For Lists / Arrays

`map` *((a, i, [a]) -> b) -> [a] -> [b]*    &nbsp;   &nbsp;   &nbsp; `flatMap` *((a, i, [a]) -> [b]) -> [a] -> [b]*  &nbsp;   &nbsp;   &nbsp; `filter` *((a, i, [a]) -> Bool) -> [a] -> [a]*    &nbsp;   &nbsp;   &nbsp; `reduce` *((a, b) -> a) -> a -> [b] -> a*

`find` *((a, i, [a]) -> Bool) -> [a] -> a*    &nbsp;   &nbsp;   &nbsp;   &nbsp; `findIndex` *((a, i, [a]) -> Bool) -> [a] -> i*    &nbsp;   &nbsp;   &nbsp;   &nbsp; `some` *((a, i, [a]) -> Bool) -> [a] -> Bool*    &nbsp;   &nbsp;   &nbsp;   &nbsp; `every` *((a, i, [a]) -> Bool) -> [a] -> Bool* 

`sort` *((a, a) -> Bool) -> [a] -> [a]*    &nbsp;   &nbsp;   &nbsp;   &nbsp; `reverse` *[a] -> [a]*    &nbsp;   &nbsp;   &nbsp;   &nbsp; `includes` *a -> [a] -> Bool*    &nbsp;   &nbsp;   &nbsp;   &nbsp; `uniq` *[a] -> [a]* 

### For Objects / Associative arrays

`prop` *k -> {k: v} -> v | null*  &nbsp;   &nbsp;   &nbsp; `pick` *[k] -> {k: v} -> {k: v} | null* &nbsp;   &nbsp;   &nbsp; `propEq` *k -> v -> {k: v} -> Bool* &nbsp;   &nbsp;   &nbsp; `propSatisfies` *(v -> Bool) -> k -> {k: v} -> Bool* 

### For function composition / functional programming

`compose`  *((y -> z), (x -> y), ... ,(a -> b)) -> (a -> z)*   &nbsp;   &nbsp;   &nbsp; `pipe` *((a -> b), (b -> c), ... , (y -> z)) -> (a -> z)* 

### Others

*not* 

## Example

```json
{
  "items": [{
      "id":1,
      "type":"train",
      "start":"2020-04-23T12:04:00.000Z",
      "end":"2020-04-23T14:08:00.000Z",
      "users":[
        { "id":1, "name":"Jimmy Page"},
        { "id":5, "name":"Roy Harper"}
      ]
    }, {
      "id":421,
      "type":"hotel",
      "start":"2020-04-23T12:00:00.000Z",
      "end":"2020-04-24T14:10:00.000Z",
      "users":[
        { "id":1, "name":"Jimmy Page" }, 
        { "id":2, "name":"Robert Plant" }
      ]
    }, {
      "id":876,
      "type":"flight",
      "start":"2020-04-23T12:04:00.000Z",
      "end":"2020-04-23T14:08:00.000Z",
      "users":[
        { "id":3, "name":"John Paul Jones" },
        { "id":4, "name":"John Bonham" }
      ]
    }]
}
```

Get all users names 

```
$get_all_users_names = F::pipe(
    F::prop('items'),
    F::flatMap(F::prop('users')),
    F::map(F::prop('name')),
    F::uniq()
);

$travel = json_decode($travelJSON);
$travels_users = $get_all_users_names($travel);

var_dump($travels_users);  //  ["Jimmy Page", "Roy Harper", "Robert Plant", "John Paul Jones", "John Bonham"]
```
