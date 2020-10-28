<?php

include '../vendor/autoload.php';

$values = array(
    'products' => array(
        'desk' => array(
            'price' => 100,
        ),
    ),
);

$array = new FightTheIce\Datatypes\Datatype\Array_();

//$array = ['products' => ['desk' => ['price' => 100]]];
$array->refresh();
$array->refresh($values);
//$array->get('products.desk.price', 'moo');
$price2 = $array->getDot('products.desk.price');
if ($price2 == 100) {
    echo 'Yes Array_ was correct' . PHP_EOL;
} else {
    echo 'No Array_ was incorrect';
}

print_r($price2);
echo PHP_EOL;