# UUIDs
FightTheIce datatypes provides a simple UUID object that is based on [ramsey/uuid](https://github.com/ramsey/uuid)


## Usage to generate a new UUID
```php
use FightTheIce\Datatypes\Scalar\Uuid_;

$uuid = new Uuid_;
echo $uuid->__toString();
```

## Generate a UUID based on an integer
```php
use FightTheIce\Datatypes\Scalar\Uuid_;

$uuid = new Uuid_(408);
echo $uuid->__toString();
//00000000-0000-0000-0000-000000000198
```

## Generate a UUID based on an integer string
```php
use FightTheIce\Datatypes\Scalar\Uuid_;

$uuid = new Uuid_('40802758989228290647962411573446946527');
echo $uuid->__toString();
//1eb25356-44a3-69ee-ab36-38c98603aedf
```

## Validate an existing UUID
```php
use FightTheIce\Datatypes\Scalar\Uuid_;

$uuid = new Uuid_('1eb25356-44a3-69ee-ab36-38c98603aedf');
echo $uuid->__toString();
```