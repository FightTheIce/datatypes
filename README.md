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
$arr = new FightTheIce\Datatypes\Compounds\Array_(array(1,2,3));
```

## Booleans

```php
$bool = new FightTheIce\Datatypes\Scalar\Boolean_(false);
```

## Floats

```php
$float = new FightTheIce\Datatypes\Scalar\Float_(1.23);
```

## Integers

```php
$int = new FightTheIce\Datatypes\Scalar\Integer_(8);
```

## Strings

There are two types of strings ... Standard strings and UnicodeStrings. UnicodeStrings are based on [symfony/string](https://github.com/symfony/string)

```php
//standard string
$standardStr = new FightTheIce\Datatypes\Scalar\String_('hello world');

//unicode string
$unicodeStr = new FightTheIce\Datatypes\Scalar\UnicodeString_('Späßchen');
```

## Lists

Arrays in PHP are everything, and nothing... So lets organize them a bit. FightTheIce lists are just structured arrays that only accept predefined data types. List feature is built on top of [spatie/typed](https://github.com/spatie/typed)

### Boolean List
```php
$boolList = new FightTheIce\Datatypes\Lists\BooleanList_(array(true,false,new FightTheIce\Datatypes\Scalar\Boolean_(true)));
```

### Float List
```php
$floatList = new FightTheIce\Datatypes\Lists\FloatList_(array(1.11,-58.123,new FightTheIce\Datatypes\Scalar\Float_(1.99)));
```

### Integer List
```php
$intList = new FightTheIce\Datatypes\Lists\IntegerList_(array(1,2,3,new FightTheIce\Datatypes\Scalar\Integer_(87)));
```

### String List
```php
$strList = new FightTheIce\Datatypes\Lists\StringList_('hello world',new FightTheIce\Datatypes\Scalar\String_('good bye'));
```