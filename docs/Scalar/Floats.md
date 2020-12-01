# Floats

# Values
Floats can be any negative, or positive value (with a decimal) that PHP supports. If you need a value larger please use NumberString.

# Usage
```php
use FightTheIce\Datatypes\Scalar\Float_;

$float = new Float_(10.7);

$isPositive = $float->isPositive(); //returns FightTheIce\Datatypes\Scalar\Boolean_
$isNegative = $float->isNegative(); //returns FightTheIce\Datatypes\Scalar\Boolean_
$isZero     = $float->isZero(); //returns FightTheIce\Datatypes\Scalar\Boolean_

$toInteger = $float->__toInteger(); //this uses intval() - returns Integer_

$abs = $float->absolute(); //returns FightTheIce\Datatypes\Scalar\Float_
$negated = $float->negated(); //returns FightTheIce\Datatypes\Scalar\Float_;
$negativeabs = $float->negativeabsolute(); //returns FightTheIce\Datatypes\Scalar\Float_

$math = $float->math(); //returns Brick\Math\BigDecimal
```