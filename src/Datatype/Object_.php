<?php

namespace FightTheIce\Datatypes\Datatype;

class Object_ {
    protected $object = null;

    public function __construct($obj) {
        if (!is_object($obj)) {
            throw new \ErrorException('must be an object');
        }

        $this->object = $obj;
    }

    public function getObject() {
        return $this->object;
    }
}