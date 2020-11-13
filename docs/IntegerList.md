# IntegerList
FightTheIce\Datatypes\Lists\IntegerList are just [Spatie\Typed\Collection](https://github.com/spatie/typed) under the hood. Which is just a structued array that only allows predefined data types.

```php
use FightTheIce\Datatypes\Scalar\Integer_;
use FightTheIce\Datatypes\Lists\IntegerList_;

$one   = new Integer_(100);
$two   = new Integer_(450);
$three = new Integer_(820);
$four  = new Integer_(9000);

$list = new IntegerList_($one,$two,$three,$four);

//now do what ever you would do with an array, noting that all the members of this array
//are of type FightTheIce\Datatypes\Scalar\Float_

$list[4] = new Integer_(7000);

$list[5] = 'some string'; //will throw exception
```