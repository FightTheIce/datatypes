# FightTheIce\Datatypes

Creating confusion since 2020. Lets make PHP a bit more "typed" (hahaha)....


```php
//native PHP
$bool = false; /* or */ $bool = true;
if (($bool==false) or ($bool==true)) {
    //soft check
}

if (($bool===false) or ($bool===true)) {
    //strict check
}

//FTI
$bool = new FightTheIce\Datatypes\Scalar\Boolean_(true);
if ($bool->isTrue()) {
    //soft check
}

if ($bool->isStrictTrue()) {
    //strict check
}
```

```php
//native php
$float = -1.0;
if ($float > 0) {
    //float is positive
} else {
    //float is negative
}
$float = abs($float);

//FTI
$float = new FightTheIce\Datatypes\Scalar\Float_(1.0);
if ($float->isPositive()) {
    //float is positive
} else {
    //float is negative
}

$float = $float->absolute();
```

```php
$int = 1;
if ($int > 0) {
    //int is positive
} else {
    //int is negative
}

//FTI
$int = new FightTheIce\Datatypes\Scalar\Integer_(1);
if ($int->isPositive()) {
    //int is positive
} else {
    //int is negative
}
```

```php
$str = '       zzzzhello worldzzzz     ';
$str = rtrim(ltrim(trim($str),'z'),'z');
//hello world

//FTI
$str = new FightTheIce\Datatypes\Scalar\String_('       zzzzhello worldzzzz     ');
$str = $str->trim()->ltrim('z')->rtrim('z');
//hello world
```

```php
//FTI
$uniStr = new FightTheIce\Datatypes\Scalar\UnicodeString_('नमस्ते दुनिया');
 //FTI Unicode is just a transparent layer on top of Symfony/String
```

```php
//native PHP
$arr = array(
    'William',
    'Frank',
    'Saul',
    null,
    false,
    new stdClass,
    'Mary',
    'Paul'
);

//remove non strings from array
$count = count($arr);
for ($a=0; $a<$count; $a++){
    if (!is_string($arr[$a])) {
        unset($arr[$a]);
    }
}

//reindex
$arr = array_values($arr);

//FTI
$arr = new FightTheIce\Datatypes\Compounds\Array_((
    'William',
    'Frank',
    'Saul',
    null,
    false,
    new stdClass,
    'Mary',
    'Paul'
));

$arr = $arr->reject(function ($name) {
    if !is_string($name);
});
```

