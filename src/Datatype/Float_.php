<?php

namespace FightTheIce\Datatypes\Datatype;

class Float_ {
    protected $float = null;

    public function __construct(float $float) {
        $this->float = $float;
    }

    public function getFloat() {
        return $this->float;
    }
}