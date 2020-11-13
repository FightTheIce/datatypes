# FloatList
FightTheIce\Datatypes\Lists\FloatList are just [Spatie\Typed\Collection](https://github.com/spatie/typed) under the hood. Which is just a structued array that only allows predefined data types.

```php
use FightTheIce\Datatypes\Scalar\Float_;
use FightTheIce\Datatypes\Lists\FloatList_;

$one   = new Float_(1.77);
$two   = new Float_(2.177);
$three = new Float_(140.60);
$four  = new Float_(600.2);

$list = new FloatList_($one,$two,$three,$four);

//now do what ever you would do with an array, noting that all the members of this array
//are of type FightTheIce\Datatypes\Scalar\Float_

$list[4] = new Float_(800.313);

$list[5] = 'some string'; //will throw exception
```