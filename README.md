# Helpers (string, array, ...)

![License](https://img.shields.io/packagist/l/corex/helpers.svg)
![Build Status](https://travis-ci.org/corex/helpers.svg?branch=master)
![codecov](https://codecov.io/gh/corex/helpers/branch/master/graph/badge.svg)


### Arr
Various array helpers.

A few examples.
```php
// Get firstname from array via dot notation.
$firstname = Arr::get($array, 'actor.firstname');

// Set firstname on array via dot notation.
Arr::set($array, 'actor.firstname', $firstname);

// Pluck firstnames from list of actors.
$firstnames = Arr::pluck($actors, 'firstname');
```


### Bag
A simple bag structure.

A few examples.
```php
// Get json.
$bag = new Bag();
$bag->set('actor.firstname', 'Roger');

// Get firstname of actor using dot notation.
$firstname = $bag->get('actor.firstname');
```


### Obj (private/protected supported)
Various methods to help getting/setting private/protected properties and more. Class overrides supported.

A few examples
```php
// Get private properties from object/class.
$properties = Obj::getProperties($myObject, null, Obj::PROPERTY_PRIVATE);

// Get interfaces from object/class.
$interfaces = Obj::getInterfaces($myObject);

// Check if interface is implemented.
if (Obj::hasInterface($myObject, myInterface::class)) {
}

// Get extends from object/class.
$extends = Obj::getExtends($myObject);

// Check if object/class is extended in specific class.
if (Obj::hasExtends($myObject, myClass::class)) {
}

// Check if object/class has method.
if (Obj::hasMethod('myMethod', $myObject)) {
}

// Set property.
Obj::setProperty('myProperty', $myObject, $value);

// Get property.
$value = Obj::getProperty('myProperty', $myObject, $default);

// Set properties.
Obj::setProperties($myObject, $propertiesValues);
```


### Str
Various string helpers (multi-byte).

A few examples.
```php
// Get first 4 characters of string.
$left = Str::left($string, 4);

// Check if string starts with 'Test'.
$startsWith = Str::startsWith($string, 'Test');

// Limit text to 20 characters with '...' at the end.
$text = Str::limit($text, 20, '...');

// Replace tokens.
$text = Str::replaceToken($text, [
    'firstname' => 'Roger',
    'lastname' => 'Moore'
]);

// Create a unique string.
$identifier = Str::unique();

// Convert to pascal case.
$data = Convention::pascalCase($data);

// Convert to camel case.
$data = Convention::camelCase($data);

// Convert to snake case.
$data = Convention::snakeCase($data);

// Convert to kebab case.
$data = Convention::kebabCase($data);
```


### StrList
Various string list helpers (multi-byte).

A few examples.
```php
// Add 'test' to string with separator '|'.
$string = StrList::add($string, 'test', '|');

// Remove 'test' from string.
$string = StrList::remove($string, 'test', '|');

// Check if 'test' exist in string.
$exist = StrList::exist($string, 'test');
```
