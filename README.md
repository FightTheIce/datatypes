# FightTheIce\Datatypes

Creating confusion since 2020. Lets make PHP a bit more "typed" (ROFL)....

# Installation

You can install the package via composer:

```
$ composer install fighttheice/datatypes
```

# Usage

## Arrays

FightTheIce - Arrays are just an extended class of [Illuminate\Support\Collection](https://github.com/illuminate/collections)

```php
use FightTheIce\Datatypes\Compounds\Array_;
$arr = new Array_(array(1,2,3));
```

## Booleans

```php
use FightTheIce\Datatypes\Scalar\Boolean_;
$bool = new Boolean_(false);
```

## Floats

```php
use FightTheIce\Datatypes\Scalar\Float_;
$float = new Float_(1.23);
```

## Integers

```php
use FightTheIce\Datatypes\Scalar\Integer_;
$int = new Integer_(8);
```

## Strings

There are two types of strings ... Standard strings and UnicodeStrings. UnicodeStrings are based on [symfony/string](https://github.com/symfony/string)

```php
//standard string
use FightTheIce\Datatypes\Scalar\String_;
$standardStr = new String_('hello world');

//unicode string
use FightTheIce\Datatypes\Scalar\UnicodeString_;
$unicodeStr = new UnicodeString_('Späßchen');
```

## Lists

Arrays in PHP are everything, and nothing... So lets organize them a bit. FightTheIce lists are just structured arrays that only accept predefined data types. List feature is built on top of [spatie/typed](https://github.com/spatie/typed)

### Boolean List
```php
use FightTheIce\Datatypes\Lists\BooleanList_;
use FightTheIce\Datatypes\Scalar\Boolean_;

$boolList = new BooleanList_(array(true,false,new Boolean_(true)));
```

### Float List
```php
use FightTheIce\Datatypes\Lists\FloatList_;
use FightTheIce\Datatypes\Scalar\Float_;
$floatList = new FloatList_(array(1.11,-58.123,new Float_(1.99)));
```

### Integer List
```php
use FightTheIce\Datatypes\Lists\IntegerList_;
use FightTheIce\Datatypes\Scalar\Integer_;
$intList = new IntegerList_(array(1,2,3,new Integer_(87)));
```

### String List
```php
use FightTheIce\Datatypes\Lists\StringList_;
use FightTheIce\Datatypes\Scalar\String_;
$strList = new StringList_('hello world',new String_('good bye'));
```