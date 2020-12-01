# UnicodeStrings
FightTheIce datatypes has two types of string classes. 

This one is called UnicodeString_

UnicodeString_ is just a wrapper class for [symfony/string](https://github.com/symfony/string)


```php
use FightTheIce\Datatypes\Scalar\UnicodeString_;

$str = new UnicodeString_('             œuvre         ');

$str = $str->ltrim();
//returns FightTheIce\Datatypes\Scalar\String_ = [œuvre         ]

$str = $str->rtrim();
//returns FightTheIce\Datatypes\Scalar\String_ = [œuvre]

$str = $str->trim();
//returns FightTheIce\Datatypes\Scalar\String_ = œuvre

$str = new UnicodeString_('GARÇON');
$str = $str->strtolower();
//returns FightTheIce\Datatypes\Scalar\String_ = [garçon]

$str = new UnicodeString_('garçon');
$str = $str->strtoupper();
//returns FightTheIce\Datatypes\Scalar\String_ = [GARÇON]

$is_empty = $str->isEmpty();
//returns FightTheIce\Datatypes\Scalar\Boolean_ = false

$length = $str->strlen();
//returns FightTheIce\Datatypes\Scalar\Integer_
//returns the width of the unicodestring
```

You can also use a string like an array
```php
use FightTheIce\Datatypes\Scalar\UnicodeString_;

$str = new String_;
$str[0] = 'G';
$str[1] = 'A';
$str[2] = 'R';
$str[3] = 'Ç';
$str[4] = 'O';
$str[5] = 'N';

echo $str[3];
//Ç
```