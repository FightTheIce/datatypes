# Integers
```php
use FightTheIce\Datatypes\Scalar\Integer_;

$int = new Integer_(1);

$is_positive = $int->isPositive();
//returns FightTheIce\Datatypes\Scalar\Boolean_ = true

$is_negative = $int->isNegative();
//returns FightTheIce\Datatypes\Scalar\Boolean_ = false

$float = new Integer_(-200);
$abs = $float->absolute();
//returns FightTheIce\Datatypes\Scalar\Float_ = 200

$float = new Integer_(512);
$ops = $float->opposite();
//returns FightTheIce\Datatypes\Scalar\Float_ = -512

$float = new Integer_(5123);
$math = $float->math();
//returns Brick\Math\BigDecimal

$integer = $float->__toFloat();
//returns FightTheIce\Datatypes\Scalar\Float_
```