# Boolean

# Values
Booleans can take one of two values, true or false.

# Usage
```php
use FightTheIce\Datatypes\Scalar\Boolean_;

$bool = new Boolean_(true);

$isTrue = $bool->isTrue(); 
//returns true

$isFalse = $bool->isFalse(); 
//returns false;

$newBool = $bool->inverse(); 
//returns the opposite boolean

$stringRep = $newBool->transform('true condition','false condition'); 
//returns FightTheIce\Datatypes\Scalar\String_
```