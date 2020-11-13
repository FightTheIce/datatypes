# Mixed
Because FightTheIce\Datatypes was trying its best to emulate native PHP data types, we have a pseudo "Mixed". Essentially this is just a wrapper class for the scalar, and compound data types.

The "exception" to this is if you send Mixed_ an existing FightTheIce data type (of scalar, or compound) the Mixed_ class will "resolve" the value.

```php
use FightTheIce\Datatypes\Pseudo\Mixed_;
use FightTheIce\Datatypes\Scalar\Integer_;
use FightTheIce\Datatypes\Scalar\Float_;
use FightTheIce\Datatypes\Scalar\Boolean_;
use FightTheIce\Datatypes\Scalar\String_;
use FightTheIce\Datatypes\Scalar\UnicodeString_;

$unknown = new Mixed_(1);
$resolved = $unknown->resolve();
//returns FightTheIce\Datatypes\Scalar\Integer_

$unknown = new Mixed_(new Integer_(1));
$resolved = $unknown->resolve();
//returns FightTheIce\Datatypes\Scalar\Integer_

$unknown = new Mixed_(1.88);
$resolved = $unknown->resolve();
//returns FightTheIce\Datatypes\Scalar\Float_

$unknown = new Mixed_(new Float_(1.88));
$resolved = $unknown->resolve();
//returns FightTheIce\Datatypes\Scalar\Float_

$unknown = new Mixed_(true);
$resolved = $unknown->resolve();
//returns FightTheIce\Datatypes\Scalar\Boolean_

$unknown = new Mixed_(new Boolean_(true));
$resolved = $unknown->resolve();
//returns FightTheIce\Datatypes\Scalar\Boolean_

$unknown = new Mixed_('hello world');
$resolved = $unknown->resolve();
//returns FightTheIce\Datatypes\Scalar\String_

$unknown = new Mixed_(new String_('hello world'));
$resolved = $unknown->resolve();
//returns FightTheIce\Datatypes\Scalar\String_

$unknown = new Mixed_('Späßchen');
$resolved = $unknown->resolve();
//returns FightTheIce\Datatypes\Scalar\UnicodeString_

$unknown = new Mixed_(new UnicodeString_('Späßchen'));
$resolved = $unknown->resolve();
//returns FightTheIce\Datatypes\Scalar\UnicodeString_

$unknown = new Mixed_(null);
$resolved = $unknown->resolve();
//returns FightTheIce\Datatypes\Special\Null_
```

Mixed_ also allows you to run a ton of different "is_a" methods

```php
use FightTheIce\Datatypes\Pseudo\Mixed_;

$unknown = new Mixed_(1);

$is_null = $unknown->is_null();
//returns FightTheIce\Datatypes\Scalar\Boolean_
/*
if ($unknown->is_null()->isFalse()) {
    //this means the value isn't null
}
*/

$is_empty = $unknown->is_empty();
//returns FightTheIce\Datatypes\Scalar\Boolean_

$is_string = $unknown->is_string();
//returns FightTheIce\Datatypes\Scalar\Boolean_

$is_unicode_string = $unknown->is_unicode_string();
//returns FightTheIce\Datatypes\Scalar\Boolean_

$is_scalar = $unknown->is_scalar();
//returns FightTheIce\Datatypes\Scalar\Boolean_

$is_float = $unknown->is_float();
//returns FightTheIce\Datatypes\Scalar\Boolean_

$is_int = $unknown->is_int();
//returns FightTheIce\Datatypes\Scalar\Boolean_

$is_bool = $unknown->is_bool();
//returns FightTheIce\Datatypes\Scalar\Boolean_

$is_object = $unknown->is_object();
//returns FightTheIce\Datatypes\Scalar\Boolean_

$is_array = $unknown->is_array();
//returns FightTheIce\Datatypes\Scalar\Boolean_

$is_numeric = $unknown->is_numeric();
//returns FightTheIce\Datatypes\Scalar\Boolean_

$is_closure = $unknown->is_closure();
//returns FightTheIce\Datatypes\Scalar\Boolean_
```

Mixed_ also has a cool utility that describes the mixed object. Nice and properly stolen from [thunderer/nevar](https://github.com/thunderer/Nevar).

For some reason this package isn't published to packagist.org so I put in an [issue](https://github.com/thunderer/Nevar/issues/3)

```php
use FightTheIce\Datatypes\Pseudo\Mixed_;

$unknown = new Mixed_(-12);
$describe = $unknown->describe();
//returns FightTheIce\Datatypes\Scalar\String = negative integer
```