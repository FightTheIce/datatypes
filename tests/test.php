<?php

include '../vendor/autoload.php';

$values = array(
    1234, //decimal
    0123, //octal = 83
    0x1A, //hex = 26
    0b11111111, //binary = 255
    10.0112323, //decimal - will drop decimal points = 10
    3e1,
    .001,
    -1.00,
);

foreach ($values as $value) {
    $integer = new FightTheIce\Datatypes\Datatype\Float_($value);
    echo $integer->getValue() . PHP_EOL . PHP_EOL;

    if ($integer->isPositive() == true) {
        echo 'Float is positive' . PHP_EOL;
    } else {
        echo 'Float is negative' . PHP_EOL;
    }

    echo str_repeat('-', 50) . PHP_EOL;
}