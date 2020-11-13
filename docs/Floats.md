# Floats
```php
use FightTheIce\Datatypes\Scalar\Float_;

$float = new Float_(1.77);

$is_positive = $float->isPositive();
//returns FightTheIce\Datatypes\Scalar\Boolean_ = true

$is_negative = $float->isNegative();
//returns FightTheIce\Datatypes\Scalar\Boolean_ = false

$float = new Float_(-200.9125);
$abs = $float->absolute();
//returns FightTheIce\Datatypes\Scalar\Float_ = 200.9125

$float = new Float_(512.2123);
$ops = $float->opposite();
//returns FightTheIce\Datatypes\Scalar\Float_ = -512.2123

$float = new Float_(5123.12321);
$math = $float->math();
//returns Brick\Math\BigDecimal

$integer = $float->__toInteger();
//returns FightTheIce\Datatypes\Scalar\Integer_
```