<?php

include '../vendor/autoload.php';

$value = array(
    'firstname' => 'William',
    'lastname'  => 'Knauss',
    'gender'    => 'male',
    'hobbies'   => array(
        'art',
        'programming',
        'photography',
    ),
);
$array = new \FightTheIce\Datatypes\Datatype\Array_($value);
$array->dot();

print_r($array->toArray());