# StringList
FightTheIce\Datatypes\Lists\StringList are just [Spatie\Typed\Collection](https://github.com/spatie/typed) under the hood. Which is just a structued array that only allows predefined data types.

```php
use FightTheIce\Datatypes\Scalar\String_;
use FightTheIce\Datatypes\Lists\StringList_;

$one   = new String_('hello world');
$two   = new String_('hello world two');
$three = new String_('hello world three');
$four  = new String_('hello world four');

$list = new StringList_($one,$two,$three,$four);

//now do what ever you would do with an array, noting that all the members of this array
//are of type FightTheIce\Datatypes\Scalar\Float_

$list[4] = new String_('good bye');

$list[5] = 700; //will throw exception
```