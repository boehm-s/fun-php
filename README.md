# F.php

Functional programming utilities for PHP !

Inspired by Javascript, Ramda, lodash and many other things !

# Installation 




# How to use it ?

You can use it just like Ramda, in fact you can even rely on the excellent [Ramda documentation!](https://ramdajs.com/docs/) !

As with Ramda, F.php methods are automatically curried !

## Implemented methods

### For Lists / Arrays

<h6> map </h6>    <h6> flatMap </h6>    <h6> filter </h6>    <h6> reduce </h6>

<h6> find </h6>    <h6> findIndex </h6>    <h6> some </h6>    <h6> every </h6>

<h6> sort </h6>    <h6> reverse </h6>    <h6> includes </h6>    <h6> uniq </h6>

### For Objects / Associative arrays

<h6> prop </h6>    <h6> pick </h6>    <h6> propEq </h6>    <h6> propSatisfies </h6>

### For function composition / functional programming

<h6> compose </h6>    <h6> pipe </h6>

### Others

<h6> not </h6>

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
