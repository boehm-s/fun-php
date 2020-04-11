# fun-php

**fun**ctional programming utilities for PHP !

Inspired by Javascript, Ramda, lodash and many other things !

# Installation 

You can clone the repo, just take the `src/fun.php` file or install the lb via composer : 

```
composer require boehm_s/fun
```

# How to use it ?

You can use it just like Ramda, in fact you can even rely on the excellent [Ramda documentation!](https://ramdajs.com/docs/) !

As with Ramda, fun-php methods are automatically curried : 

```
F::map($fn, $array)  <==>  F::map($fn)($array)  <==>  F::map()($fn)($array)
```

## Implemented methods

**fun-php** is just a bunch of static methods. To use them, juste prefix the following functions with `F::`

### For Lists / Arrays

| function   | type                                  | function     | type                                |
| ---------  | ------------------------------------- | ------------ | ----------------------------------- |
| *map*      | `((a, i, [a]) → b) → [a] → [b]`       | *flatMap*    | `((a, i, [a]) → [b]) → [a] → [b]`   |
| *filter*   | `((a, i, [a]) → Bool) → [a] → [a]`    | *reduce*     | `((a, b) → a) → a → [b] → a`        |
| *find*     | `((a, i, [a]) → Bool) → [a] → a`      | *findIndex*  | `((a, i, [a]) → Bool) → [a] → i`    |
| *some*     | `((a, i, [a]) → Bool) → [a] → Bool`   | *every*      | `((a, i, [a]) → Bool) → [a] → Bool` |
| *sort*     | `((a, a) → Bool) → [a] → [a]`         | *reverse*    | `[a] → [a]`                         |
| *includes* | `a → [a] → Bool`                      | *uniq*       | `[a] → [a]`                         |

### For Objects / Associative arrays

| function  | type                                  | function        | type                                |
| --------- | ------------------------------------- | ------------    | ----------------------------------- |
| *prop*    | `k → {k: v} → v \| null`              | *pick*          | `[k] → {k: v} → {k: v} \| null`     |
| *propEq*  | `k → v → {k: v} → Bool`               | *propSatisfies* | `(v → Bool) → k → {k: v} → Bool`    |

### For function composition / functional programming

| function  | type                                         | function     | type                                          |
| --------- | -------------------------------------------- | ------------ | --------------------------------------------  |
| *compose* | `((y → z), (x → y), ... ,(a → b)) → (a → z)` | *pipe*       | `((a → b), (b → c), ... , (y → z)) → (a → z)` |

### Others

| function  | type          | function | type  |
| --------- | ------------- | -------- | ----- |
| *not*     | `* → Boolean` |          |       |

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
