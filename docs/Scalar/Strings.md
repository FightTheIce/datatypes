# Strings
FightTheIce datatypes has two types of string classes. This one is called String_ or (standardString).


It should be noted if you start with a String_ and start adding Unicode characters the class will not automaticlly convert the string to a UnicodeString_

```php
use FightTheIce\Datatypes\Scalar\String_;

$str = new String_('      zzHello Worldzz    ');
$str = $str->trim();
//returns FightTheIce\Datatypes\Scalar\String_ = zzHello Worldzz

$str = $str->ltrim('z');
//returns FightTheIce\Datatypes\Scalar\String_ = Hello Worldzz

$str = $str->rtrim('z');
//returns FightTheIce\Datatypes\Scalar\String_ = Hello World

$str = $str->strtolower();
//returns FightTheIce\Datatypes\Scalar\String_ = hello world

$str = $str->strtoupper();
//returns FightTheIce\Datatypes\Scalar\String_ = HELLO WORLD

$is_empty = $str->isEmpty();
//returns FightTheIce\Datatypes\Scalar\Boolean_ = false

$length = $str->strlen();
//returns FightTheIce\Datatypes\Scalar\Integer_
```

You can also use a string like an array
```php
use FightTheIce\Datatypes\Scalar\String_;

$str = new String_;
$str[0] = 'a';
$str[1] = 'b';
$str[2] = 'c';

echo $str[0];
//a
```