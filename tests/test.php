<?php

include '../vendor/autoload.php';

$array = ['name' => 'Taylor', 'order' => ['column' => 'created_at', 'direction' => 'desc']];
print_r($array);

$value[0] = array(
    0 => 'zero',
    1 => 'one',
    2 => 'two',
);

$value[1] = array(
    'animal' => 'frog',
);

$arr = new Illuminate\Support\Arr;

if ($arr->isAssoc($value[0]) == true) {
    echo 'ARR: First array is assoc' . PHP_EOL;
} else {
    echo 'ARR: First array is NOT assoc' . PHP_EOL;
}
echo PHP_EOL;

if ($arr->isAssoc($value[1]) == true) {
    echo 'ARR: Second array is assoc' . PHP_EOL;
} else {
    echo 'ARR: Second array is NOT assoc' . PHP_EOL;
}
echo PHP_EOL;

$array = new FightTheIce\Datatypes\Datatype\Array_($value[0]);
if ($array->isAssoc() == true) {
    echo 'ARRAY: First array is assoc' . PHP_EOL;
} else {
    echo 'ARRAY: First array is NOT assoc' . PHP_EOL;
}
echo PHP_EOL;

$array = new FightTheIce\Datatypes\Datatype\Array_($value[1]);
if ($array->isAssoc() == true) {
    echo 'ARRAY: Second array is assoc' . PHP_EOL;
} else {
    echo 'ARRAY: Second array is NOT assoc' . PHP_EOL;
}
echo PHP_EOL;