# Booleans

```php
use FightTheIce\Datatypes\Scalar\Boolean_;

$bool = new Boolean_(true);

$isTrue = $bool->isTrue(); 
//returns true
$isFalse = $bool->isFalse();
//returns false

$bool = new Boolean_(false);
$transform = $bool->transform('yes','no');
//returns FightTheIce\Datatypes\Scalar\String_ = yes

$bool = new Boolean_(false);
$bool = $bool->inverse();
```