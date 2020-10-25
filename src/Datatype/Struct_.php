<?php

namespace FightTheIce\Datatypes\Datatype;

class Struct_ extends StdClass_ {
    protected $map = null;

    public function __construct($map) {
        //validate our map
        if (!isset($map['properties'])) {
            throw new \ErrorException('X-1');
        }

        foreach ($map['properties'] as $name => $attributes) {

        }
    }

    public function __get(string $propertyName) {
        echo 'GET: ' . $propertyName . PHP_EOL;
    }

    public function __set(string $propertyName, $value) {
        echo 'SET: ' . $propertyName . PHP_EOL;
    }
}

/*
'properties' => array(
'firstname' => array(
'immutable' => false
'datatype' => ''
),
'lastname' => array(
'immutable' => true
)
)
 */