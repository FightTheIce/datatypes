<?php

namespace FightTheIce\Datatypes\Datatype;

use FightTheIce\Datatypes\Core\Interfaces\DatatypeInterface;
use Illuminate\Support\Traits\Macroable;

class Boolean_ implements DatatypeInterface {
    use Macroable;

    protected $boolean = null;

    public function __construct(bool $bool) {
        $this->boolean = $bool;
    }

    public function getBoolean() {
        return $this->boolean;
    }

    public function isTrue() {
        if ($this->boolean == true) {
            return true;
        }

        return false;
    }

    public function isFalse() {
        if ($this->boolean == false) {
            return true;
        }

        return false;
    }

    public function inverse() {
        if ($this->boolean == true) {
            self::__construct(false);
        } else {
            self::__construct(true);
        }

        return $this;
    }

    public function getType() {
        return 'boolean';
    }

    public function getValue() {
        return $this->boolean;
    }
}