# FightTheIce\Datatypes

Creating confusion since 2020. Lets make PHP a bit more "typed" (ROFL)....

# License
The code is currently released under the MIT license. 

# Installation

You can install the package via composer:

```
$ composer install fighttheice/datatypes
```

# Tests
Tests are included in the tests/ directory. If you go to the root of the project and run
./vendor/bin/phpunit all the tests will run.

Datatype                                   | Type          
------------------------------------------ | --------------------------------------
[Boolean](docs/Booleans.md)                | scalar        
[Integer](docs/Integers.md)                | scalar        
[Float](docs/Floats.md)                    | scalar        
[String](docs/Strings.md)                  | scalar        
[Array](docs/Arrays.md)                    | compound      
[Object](docs/Objects.md)                  | compound      
[Callable](docs/Callables.md)              | compound      
[Iterable](docs/Iterables.md)              | compound      
[Resource](docs/Resources.md)              | special       
[Null](docs/Nulls.md)                      | special       
[Mixed](docs/Mixeds.md)                    | pseudo        
[Void](docs/Voids.md)                      | pseudo        
[Number](docs/Numbers.md)                  | pseudo
[String](docs/PseudoStrings.md)            | pseudo
[NumberString](docs/NumberStrings.md)      | scalar
[UnicodeString](docs/UnicodeStrings.md)    | scalar
[Uuid](docs/Uuids.md)                      | complex
[Datetime](docs/Datetimes.md)              | complex
[Closure](docs/Closures.md)                | complex