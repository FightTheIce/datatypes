<?php

namespace FightTheIce\Datatypes\Datatype;

use FightTheIce\Datatypes\Core\Interfaces\DatatypeInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\Support\Traits\Macroable;

class Array_ implements DatatypeInterface {
    use ForwardsCalls;
    use Macroable {
        __call as parent__call;
    }

    protected $array      = null;
    protected $collection = null;

    public function __construct(array $array) {
        $this->array      = $array;
        $this->collection = new Collection($array);
    }

    public function getArray() {
        return $this->array;
    }

    public function __call(string $name, array $arguments) {
        if (method_exists($this->collection, $name)) {
            $response = $this->forwardCallTo($this->collection, $name, $arguments);
            if (is_object($response)) {
                $this->collection = $response;
                $this->array      = $this->collection->toArray();
                return $this;
            } else {
                return $response;
            }
        } else {
            return $this->parent__call($name, $arguments);
        }
    }

    public function getType() {
        return 'array';
    }

    public function getValue() {
        return $this->array;
    }
}