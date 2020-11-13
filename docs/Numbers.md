# Number
Because FightTheIce\Datatypes was trying its best to emulate native PHP data types, we have a pseudo "Number". Essentially this is just a wrapper class Integer_, and Float_.

```php
use FightTheIce\Datatypes\Pseudo\Number_;

$number = new Number_(1);
$resolved = $number->resolve();
//return return FightTheIce\Datatypes\Scalar\Integer_

$number = new Number_(19.33);
$resolved = $number->resolve();
//return return FightTheIce\Datatypes\Scalar\Float_
```