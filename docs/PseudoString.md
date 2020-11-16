# String
Because FightTheIce\Datatypes was trying its best to emulate native PHP data types, we have a pseudo "String". Essentially this is just a wrapper class for String_ and UnicodeString_

Pseudo\String_ contains all the same string methods that String_ and Unicode_ string have. It is smart enough to know when your string contains unicode characters and will automaticly start using the UnicodeString_ class when necessary. Of course there is a trade off and that is speed, since using Pseudo\String_ will essentially double the amount of calls. 

```php
use FightTheIce\Datatypes\Pseudo\String_;

$str = new String_('p');
$str[1] = 'roly not unicode';
$is_standardString = $str->isStandard();
//returns FightTheIce\Datatypes\Scalar\Boolean_ = true

$resolved = $str->resolve();
//returns FightTheIce\Datatypes\Scalar\String_ = proly not unicode

$str = new String_('Ç');
$is_unicodeString = $str->isUnicode();
//returns FightTheIce\Datatypes\Scalar\Boolean_ = true

/*
You can also call any standard string method such as (but not limited to)
$str->ltrim();
$str->trim();
$str->rtrim();
*/
```

You can also use a string like an array
```php
use FightTheIce\Datatypes\Pseudo\String_;

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