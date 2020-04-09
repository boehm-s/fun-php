# F.php

Functional programming utilities for PHP !

Inspired by Javascript, Ramda, lodash and many other things !

# Installation 




# How to use it ?

You can use it just like Ramda, in fact you can even rely on the excellent [Ramda documentation!](https://ramdajs.com/docs/) !

As with Ramda, F.php methods are automatically curried !

## Implemented methods

### For Lists / Arrays

*map*     &nbsp;   &nbsp;   &nbsp;   &nbsp; *flatMap*     &nbsp;   &nbsp;   &nbsp;   &nbsp; *filter*     &nbsp;   &nbsp;   &nbsp;   &nbsp; *reduce* 

*find*     &nbsp;   &nbsp;   &nbsp;   &nbsp; *findIndex*     &nbsp;   &nbsp;   &nbsp;   &nbsp; *some*     &nbsp;   &nbsp;   &nbsp;   &nbsp; *every* 

*sort*     &nbsp;   &nbsp;   &nbsp;   &nbsp; *reverse*     &nbsp;   &nbsp;   &nbsp;   &nbsp; *includes*     &nbsp;   &nbsp;   &nbsp;   &nbsp; *uniq* 

### For Objects / Associative arrays

*prop*     &nbsp;   &nbsp;   &nbsp;   &nbsp; *pick*     &nbsp;   &nbsp;   &nbsp;   &nbsp; *propEq*     &nbsp;   &nbsp;   &nbsp;   &nbsp; *propSatisfies* 

### For function composition / functional programming

*compose*     &nbsp;   &nbsp;   &nbsp;   &nbsp; *pipe* 

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
