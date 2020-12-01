# Resources
FightTheIce datatypes includes Resources_.... This isn't decent don't use it

```php
use FightTheIce\Datatypes\Special\Resource_;

$res = @\fopen('php://memory', 'rb');
$resource = new Resource_($res);

$type = $resource->get_type();
//does an underlying call to get_resource_type
```