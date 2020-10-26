<?php

namespace FightTheIce\Datatypes\Datatype;

class Integer_ {
    protected $integer = null;

    public function __construct(int $integer) {
        $this->integer = $integer;
    }

    public function getInteger() {
        return $this->integer;
    }
}