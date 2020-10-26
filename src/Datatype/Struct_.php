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
            if (empty($name)) {
                throw new \ErrorException('Property must have a name');
            }

            if (empty($attributes)) {
                throw new \ErrorException('Property must have attributes');
            }

            if (!isset($attributes['datatype'])) {
                throw new \ErrorException('Property must have a datatype');
            }

            $this->map['properties'][$name]['attributes'] = $attributes;
        }
    }

    public function __get(string $propertyName) {
        if (!isset($this->map['properties'][$propertyName])) {
            throw new \ErrorException('Notice: Undefined property: $' . $propertyName);
        }

        if (!isset($this->map['properties'][$propertyName]['value'])) {
            throw new \ErrorException('Notice: Undefined property value: $' . $propertyName);
        }

        return $this->map['properties'][$propertyName]['value'];
    }

    public function __set(string $propertyName, $value) {
        if (!isset($this->map['properties'][$propertyName])) {
            throw new \ErrorException('Notice: Undefined property: $' . $propertyName);
        }

        if (is_subclass_of($value, $this->map['properties'][$propertyName]['attributes']['datatype']) == false) {
            throw new \ErrorException('Invalid Datatype for property: $' . $propertyName);
        }

        $this->map['properties'][$propertyName]['value'] = $value;
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