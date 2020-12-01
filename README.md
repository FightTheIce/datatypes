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
[Boolean](docs/Scalar/Booleans.md)                | scalar        
[Integer](docs/Scalar/Integers.md)                | scalar        
[Float](docs/Scalar/Floats.md)                    | scalar        
[String](docs/Scalar/Strings.md)                  | scalar        
[Array](docs/Compound/Arrays.md)                    | compound      
[Object](docs/Compound/Objects.md)                  | compound      
[Callable](docs/Compound/Callables.md)              | compound      
[Iterable](docs/Compound/Iterables.md)              | compound      
[Resource](docs/Special/Resources.md)              | special       
[Null](docs/Special/Nulls.md)                      | special       
[Mixed](docs/Pseudo/Mixeds.md)                    | pseudo        
[Void](docs/Pseudo/Voids.md)                      | pseudo        
[Number](docs/Pseudo/Numbers.md)                  | pseudo
[String](docs/Pseudo/PseudoStrings.md)            | pseudo
[NumberString](docs/Scalar/NumberStrings.md)      | scalar
[UnicodeString](docs/Scalar/UnicodeStrings.md)    | scalar
[Uuid](docs/Complex/Uuids.md)                      | complex
[Datetime](docs/Complex/Datetimes.md)              | complex
[Closure](docs/Complex/Closures.md)                | complex

# Releases
While releases have been made (even marked as production worthy) this project is still experimental.