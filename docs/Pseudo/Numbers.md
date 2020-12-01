# Numbers
Numbers is to be used when you don't know if you are dealing with a numberstring, integer, or float.

```php
use FightTheIce\Datatypes\Pseudo\Number_;

$num = new Number_(100);

$isFloat = $num->is_float(); 
//returns FightTheIce\Datatypes\Scalar\Boolean_

$isInt   = $num->is_integer(); 
//returns FightTheIce\Datatypes\Scalar\Boolean_

$resolve = $num->resolve(); 
//Number_(100) = returns FightTheIce\Datatypes\Scalar\Integer_

$num = new Number(100.77);

$resolve = $num->resolve(); 
//Number_(100.77) = returns FightTheIce\Datatypes\Scalar\Float_
```