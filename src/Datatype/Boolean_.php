<?php

namespace FightTheIce\Datatypes\Datatype;

use FightTheIce\Datatypes\Core\DataTypeInterface;
use FightTheIce\Datatypes\Core\Macroable;
use FightTheIce\Datatypes\Core\StringInterface;
use Symfony\Component\String\ByteString;
use Symfony\Component\String\UnicodeString;

class Boolean_ implements DataTypeInterface {
    protected $bool = null;

    public function __construct(bool $bool) {
        $this->bool = $bool;
    }

    public function isTrue() {
        if ($this->bool == true) {
            return true;
        }

        return false;
    }

    public function isStrictTrue() {
        if ($this->bool === true) {
            return true;
        }

        return false;
    }

    public function isFalse() {
        if ($this->bool == false) {
            return true;
        }

        return false;
    }

    public function isStrictFalse() {
        if ($this->bool === false) {
            return true;
        }

        return false;
    }

    public function inverse() {
        if ($this->bool) {
            $this->bool = false;
        }

        $this->bool = true;

        return $this;
    }
}