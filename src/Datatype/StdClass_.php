<?php

namespace FightTheIce\Datatypes\Datatype;

use Closure;
use FightTheIce\Datatypes\Core\Castable_;
use FightTheIce\Datatypes\Core\DataTypeInterface;
use FightTheIce\Datatypes\Core\Macroable;
use StdClass;

class StdClass_ extends StdClass implements DataTypeInterface {
    use Macroable;

    public function cast() {
        return new Castable_($this);
    }

    public function newProperty(string $name, $value) {
        $this->{$name} = $value;

        return $this;
    }

    public function newMethod(string $name, Closure $method) {
        $this->macro($name, $method);

        return $this;
    }
}

/*
__get($propertyName)    The __get() method will be called when getting a member variable of a class.
__set($property, $value)    The __set() method will be called when setting a member variable of a class.
__isset($content)     The __isset() method will be called when calling isset()  or empty() for an undefined or inaccessible member.
__unset($content)    The __unset() method will be called when calling reset() for an undefined or inaccessible member.
 */