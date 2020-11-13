# BooleanList
FightTheIce\Datatypes\Lists\BooleanList are just [Spatie\Typed\Collection](https://github.com/spatie/typed) under the hood. Which is just a structued array that only allows predefined data types.

```php
use FightTheIce\Datatypes\Scalar\Boolean_;
use FightTheIce\Datatypes\Lists\BooleanList_;

$true = new Boolean_(true);
$false = new Boolean_(false);
$otrue = new Boolean_(true);
$ofalse = new Boolean_(false);

$list = new BooleanList_($true,$false,$otrue,$ofalse);

//now do what ever you would do with an array, noting that all the members of this array
//are of type FightTheIce\Datatypes\Scalar\Boolean_

$list[4] = new Boolean_(true);

$list[5] = 'some string'; //will throw exception
```