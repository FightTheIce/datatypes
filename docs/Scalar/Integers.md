# Integers

# Values
Integers can be any negative, or positive integer (without a decimal) value that PHP supports. If you need a value larger please use NumberString.

# Usage
```php
use FightTheIce\Datatypes\Scalar\Integer_;

$int = new Integer_(100);

$isPositive = $int->isPositive(); 
//returns FightTheIce\Datatypes\Scalar\Boolean_
$isNegative = $int->isNegative(); 
//returns FightTheIce\Datatypes\Scalar\Boolean_
$isZero     = $int->isZero(); 
//returns FightTheIce\Datatypes\Scalar\Boolean_

$toFloat = $int->__toFloat(); 
//this uses floatval()

$abs = $int->absolute(); 
//returns FightTheIce\Datatypes\Scalar\Integer_

$negated = $int->negated(); 
//returns FightTheIce\Datatypes\Scalar\Integer_;

$negativeabs = $int->negativeabsolute(); 
//returns FightTheIce\Datatypes\Scalar\Integer_

$math = $int->math(); 
//returns Brick\Math\BigInteger
```