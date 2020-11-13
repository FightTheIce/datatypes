# String
Because FightTheIce\Datatypes was trying its best to emulate native PHP data types, we have a pseudo "String". Essentially this is just a wrapper class for String_ and UnicodeString_

Keep in mind that if you are using a FightTheIce\Datatypes\Scalar\String_ object and add unicode
characters the class does not automaticly convert it to UnicodeString

```php
use FightTheIce\Datatypes\Pseudo\String_;

$str = new String_('proly not unicode');
$resolved = $number->resolve();
//return return FightTheIce\Datatypes\Scalar\String_

$number = new String_('Späßchen');
$resolved = $number->resolve();
//return return FightTheIce\Datatypes\Scalar\UnicodeString_
```