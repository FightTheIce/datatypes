# Arrays
FightTheIce\Datatypes\Compounds\Arrays_ are just Laravel Collections under the hood... no literally the class Array_ just extends Illuminate\Support\Collection.

Have a look at the [Laravel Manual](https://laravel.com/docs/8.x/collections) to see the base features of this datatype.

FightTheIce also added some premade macros by spatie. [spatie/laravel-collection-macros](https://github.com/spatie/laravel-collection-macros).

Array_ also contains some additional methods supported by Illuminate\Support\Arr (which is included in the illuminate/collections package).

Most but not all methods return an immutable object. 

## Usage

```php
use FightTheIce\Datatypes\Compounds\Array_;

$arr = new Array_; //init an empty "array"
$arr[0] = 'Tim';
$arr[1] = 'Tom';
$arr[2] = 'Terry';
```

```php
use FightTheIce\Datatypes\Compounds\Array_;

$arr = new Array_(array('Tim','Tom','Terry'));
```

## Dot Helpers
```php
use FightTheIce\Datatypes\Compounds\Array_;

$arr = new Array_(array('Tim','Tom','Terry'));

//Add an element to an array using "dot" notation 
//if it doesn't exist, overwrite it if it does exists
$arr = $arr->addDot('name','John');

//Remove one item from a given array using "dot" notation.
$arr = $arr->removeDot('name');

//Get an item from an array using "dot" notation.
$tim = $arr->getDot('0');
//will return "Tim"

//Set an array item to a given value using "dot" notation.
$arr = $arr->setDot('day','Monday');

//Check if an item exist in an array using "dot" notation.
$bool = $arr->hasDot('day');
```

## Export Helpers
Array_ also includes a few export helpers from the following packages:

* symfony/yaml
* nette/neon

```php
use FightTheIce\Datatypes\Compounds\Array_;

$arr = new Array_(array('Tim','Tom','Terry'));

//export as json
$json = $arr->toJson();

//export as yaml
$yaml = $arr->toYaml();

//export as neon
$neon = $arr->toNeon();

//export as json
$json = $arr->toJson();
```


