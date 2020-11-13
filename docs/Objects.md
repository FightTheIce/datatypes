# Objects
FightTheIce\Datatypes\Compounds\Objects_ is just an encapsulation class for an existing object.
It really doesn't have any value...

```php
use FightTheIce\Datatypes\Compounds\Objects_;

$obj = new Object_(new stdClass);

//get reflection
$reflection = $obj->getReflection();
//will return ReflectionClass

$obj = new Object_(new function() {
    echo 'Hello World';
});
//ReflectionFunction

$resolved = $obj->resolve();
//will return the encapsulated object

$obj = new Object_(new stdClass);
$hash = $obj->getHash();
//will return FightTheIce\Datatypes\Scalar\String_
//underlying code calls spl_object_hash

$id = $obj->getId();
//will return FightTheIce\Datatypes\Scalar\Integer_
//underlying code calls spl_object_id
```