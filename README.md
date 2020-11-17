# FightTheIce\Datatypes

Creating confusion since 2020. Lets make PHP a bit more "typed" (ROFL)....

# License
The code is currently released under the MIT license. 

# Installation

You can install the package via composer:

```
$ composer install fighttheice/datatypes
```

# Tests
Tests are included in the tests/ directory. If you go to the root of the project and run
./vendor/bin/phpunit all the tests will run.

# Summary
@see - https://www.php.net/manual/en/language.types.intro.php

Datatype         | Primitive Type  | Completed
------------     | -------------   | -------------
Boolean (bool)   | Scalar          | Completed
Integer (int)    | Scalar          | Completed
Float (double)   | Scalar          | Completed
String (unicode) | Scalar          | Completed
Array            | Compound        | Completed
Object           | Compound        | Completed
Callable         | Compound        | Not started
Iterable         | Compound        | Not started
Resource         | Special         | Completed
NULL             | Special         | Completed
mixed            | Pseudo          | Completed
void             | Pseudo          | Not started
~                | ~               | ~
UUID             | Scalar (string) | Completed
UnicodeString    | Scalar (string) | Completed
Datetime         | Scalar (string) | Completed


# Usage

## [Arrays](docs/Arrays.md)

FightTheIce - Arrays are just an extended class of [Illuminate\Support\Collection](https://github.com/illuminate/collections)

```php
use FightTheIce\Datatypes\Compounds\Array_;

$arr = new Array_(array(1,2,3));
```

## [Booleans](docs/Booleans.md)

```php
use FightTheIce\Datatypes\Scalar\Boolean_;

$bool = new Boolean_(false);
```

## [Floats](docs/Floats.md)

```php
use FightTheIce\Datatypes\Scalar\Float_;

$float = new Float_(1.23);
```

Floats by themselves are a bit boring, so you can get a math instance. To do some calculations.
This returns a [brick/math](https://github.com/brick/math)
```php
use FightTheIce\Datatypes\Scalar\Float_;

$float = new Float_(1.77)->math();
//returns Brick\Math\BigDecimal
```

## [Integers](docs/Integers.md)

```php
use FightTheIce\Datatypes\Scalar\Integer_;

$int = new Integer_(8);
```

Integers by themselves are a bit boring, so you can get a math instance. To do some calculations.
This returns a [brick/math](https://github.com/brick/math)
```php
use FightTheIce\Datatypes\Scalar\Integer_;

$float = new Integer_(100)->math();
//returns Brick\Math\BigInteger
```

## [Strings](docs/Strings.md) - [UnicodeStrings](docs/UnicodeStrings.md)

There are two types of strings ... Standard strings and UnicodeStrings. UnicodeStrings are based on [symfony/string](https://github.com/symfony/string)

```php
//standard string
use FightTheIce\Datatypes\Scalar\String_;

$standardStr = new String_('hello world');

//unicode string
use FightTheIce\Datatypes\Scalar\UnicodeString_;

$unicodeStr = new UnicodeString_('Späßchen');
```


## [Pseudo Strings](docs/PseudoStrings.md)
Sometimes you may not know if your dealing a unicode string. FightTheIce has you covered
```php
use FightTheIce\Datatypes\Pseudo\String_;

$unknownstring = new String_('proly not unicode');
$resolvedStr = $unknownstring->resolve();
//returns FightTheIce\Datatypes\Scalar\String_

$unknownstring = new String_('Späßchen');
$resolvedStr = $unknownstring->resolve();
//returns FightTheIce\Datatypes\Scalar\UnicodeString_
```

## [Pseudo Numbers](docs/PseudoNumbers.md)
If for some reason you don't know what type of number (integer, or float) you are dealing with. Don't worry FightTheIce has you covered

```php
use FightTheIce\Datatypes\Pseudo\Number_;

$unknownnum = new Number_(1.77);
$resolvedNum = $unknownnum->resolve();
//returns FightTheIce\Datatypes\Scalar\Float_

$unknownnum = new Number_(18213);
$resolvedNum = $unknownnum->resolve();
//returns FightTheIce\Datatypes\Scalar\Integer_
```

## Lists

Arrays in PHP are everything, and nothing... So lets organize them a bit. FightTheIce lists are just structured arrays that only accept predefined data types. List feature is built on top of [spatie/typed](https://github.com/spatie/typed)

### [Boolean List](docs/BooleanList.md)
```php
use FightTheIce\Datatypes\Lists\BooleanList_;
use FightTheIce\Datatypes\Scalar\Boolean_;

$boolList = new BooleanList_(array(true,false,new Boolean_(true)));
```

### [Float List](docs/FloatList.md)
```php
use FightTheIce\Datatypes\Lists\FloatList_;
use FightTheIce\Datatypes\Scalar\Float_;

$floatList = new FloatList_(array(1.11,-58.123,new Float_(1.99)));
```

### [Integer List](docs/IntegerList.md)
```php
use FightTheIce\Datatypes\Lists\IntegerList_;
use FightTheIce\Datatypes\Scalar\Integer_;

$intList = new IntegerList_(array(1,2,3,new Integer_(87)));
```

### [String List](docs/StringList.md)
```php
use FightTheIce\Datatypes\Lists\StringList_;
use FightTheIce\Datatypes\Scalar\String_;

$strList = new StringList_('hello world',new String_('good bye'));
```

## [UUID](docs/Uuids.md)
UUIDs are built on top of [ramsey/uuid](https://github.com/ramsey/uuid)

```php
use FightTheIce\Datatypes\Scalar\Uuid_;

$uuid = new Uuid_;
```

## [Mythical Magic - Mixed](docs/Mixed.md)
If for some reason you don't know what data type you are dealing... which is doubtful.
FightTheIce has you covered
```php
use FightTheIce\Datatypes\Pseudo\Mixed_;

$unknown = new Mixed_(1);
$resolved = $unknown->resolve();
//returns FightTheIce\Datatypes\Scalar\Integer_

$unknown = new Mixed_(1.88);
$resolved = $unknown->resolve();
//returns FightTheIce\Datatypes\Scalar\Float_

$unknown = new Mixed_(true);
$resolved = $unknown->resolve();
//returns FightTheIce\Datatypes\Scalar\Boolean_

$unknown = new Mixed_('hello world');
$resolved = $unknown->resolve();
//returns FightTheIce\Datatypes\Scalar\String_

$unknown = new Mixed_('Späßchen');
$resolved = $unknown->resolve();
//returns FightTheIce\Datatypes\Scalar\UnicodeString_
```

## Useless but fun
FightTheIce includes some useless but never the less fun data types to

### [Objects](docs/Objects.md)
```php
use FightTheIce\Datatypes\Compounds\Object_;

$obj = new Object_(new stdClass);
```

### [Nulls](docs/Nulls.md)
```php
use FightTheIce\Datatypes\Special\Null_;

$null = new Null_;
```

### [Resources](docs/Resources.md)
```php
use FightTheIce\Datatypes\Special\Resource_;

$resource = new Resource_();
```