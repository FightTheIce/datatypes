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

# Summary
@see - https://www.php.net/manual/en/language.types.intro.php

Datatype         | Type          | Link
------------     | ------------- | -------------
Boolean          | scalar        | https://www.php.net/manual/en/language.types.boolean.php
Integer          | scalar        | https://www.php.net/manual/en/language.types.integer.php
Float            | scalar        | https://www.php.net/manual/en/language.types.float.php
String           | scalar        | https://www.php.net/manual/en/language.types.string.php
Array            | compound      | https://www.php.net/manual/en/language.types.array.php
Object           | compound      | https://www.php.net/manual/en/language.types.object.php
Callable         | compound      | https://www.php.net/manual/en/language.types.callable.php
Iterable         | compound      | https://www.php.net/manual/en/language.types.iterable.php
Resource         | special       | https://www.php.net/manual/en/language.types.resource.php
Null             | special       | https://www.php.net/manual/en/language.types.null.php
Mixed            | pseudo        | https://www.php.net/manual/en/language.pseudo-types.php
Void             | pseudo        | https://www.php.net/manual/en/language.pseudo-types.php

Datatype         | Type
------------     | ------------ 
Number           | pseudo
String           | pseudo
NumberString     | scalar
UnicodeString    | scalar
Uuid             | complex
Datetime         | complex
Closure          | complex