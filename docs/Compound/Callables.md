# Callables
FightTheIce\Datatypes\Compounds\Callable_ is just an encapsulation class for an existing callable.
It really doesn't have any value...

```php
use FightTheIce\Datatypes\Compound\Callable_;

$aFunc = function() {
    echo 'Hello World';
};

$callable = new Callable_($aFunc);

$resolved = $callable->resolveCallable(); 
//resolve the callable

$isStringCallable = $callable->is_callable_string(); 
//returns FightTheIce\Datatypes\Scalar\Boolean_

$isArrayCallable  = $callable->is_callable_array(); 
//returns FightTheIce\Datatypes\Scalar\Boolean_

$isClosureCallable = $callable->is_callable_closure(); 
//returns FightTheIce\Datatypes\Scalar\Boolean_
```