<?php

namespace FightTheIce\Datatypes\Datatype;

class String_ {
    protected $string = null;

    public function __construct(string $string) {
        $this->string = $string;
    }

    public function getString() {
        return $this->string;
    }

    public function __toString() {
        return $this->string;
    }
}