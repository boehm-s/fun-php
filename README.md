# fun-php

**fun**ctional programming utilities for PHP ! Inspired by *Ramda*, Javascript, lodash and many other things !

## Why ? 

Because PHP lacks of simple and easy-to-use utilities for functional programming !

# Installation 

```
composer require boehm_s/fun
```

# How to use it ?

You can use it just like Ramda, in fact you can even rely on the excellent [Ramda documentation!](https://ramdajs.com/docs/) !

As with Ramda, fun-php methods are automatically curried : 

`F::map($fn, $array)` &nbsp; ⇔  &nbsp; `F::map($fn)($array)` &nbsp; ⇔  &nbsp; `F::map()($fn)($array)`

Also placeholders are implemented. fun-php placeholder is `F::_` : 

`F::map(F::_, $array)($fn)` &nbsp; ⇔  &nbsp; `F::map($fn)(F::_)($fn)` &nbsp; ⇔  &nbsp; `F::map(F::_)($fn)($array)`


## Example

```json
{
  "items": [{
      "id":1,
      "type":"train",
      "users":[
        { "id":1, "name":"Jimmy Page"},
        { "id":5, "name":"Roy Harper"}
      ]
    }, {
      "id":421,
      "type":"hotel",
      "users":[
        { "id":1, "name":"Jimmy Page" }, 
        { "id":2, "name":"Robert Plant" }
      ]
    }, {
      "id":876,
      "type":"flight",
      "users":[
        { "id":3, "name":"John Paul Jones" },
        { "id":4, "name":"John Bonham" }
      ]
    }]
}
```

Get all users names 

```php
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

| function  | type                                          |
| --------- | --------------------------------------------  |
| *compose* | `((y → z), (x → y), ... ,(a → b)) → (a → z)`  |
| *pipe*    | `((a → b), (b → c), ... , (y → z)) → (a → z)` |

### Others

| function  | type          |
| --------- | ------------- |
| *not*     | `* → Boolean` |
