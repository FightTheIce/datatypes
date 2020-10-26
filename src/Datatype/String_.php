<?php

namespace FightTheIce\Datatypes\Datatype;

use FightTheIce\Datatypes\Core\DataTypeInterface;
use FightTheIce\Datatypes\Core\Macroable;
use FightTheIce\Datatypes\Core\StringInterface;
use function ltrim;
use function rtrim;
use function trim;

class String_ implements DataTypeInterface, StringInterface {
    protected $str = null;

    public function __construct(string $str) {
        $this->str = $str;
    }

    public function trim(string $character_mask = " \t\n\r\0\x0B"): self{
        $this->str = trim($this->string, $character_mask);

        return $this;
    }

    public function ltrim(string $character_mask = " \t\n\r\0\x0B"): self{
        $this->str = ltrim($character_mask);

        return $this;
    }

    public function rtrim(string $character_mask = " \t\n\r\0\x0B"): self{
        $this->str = rtrim($character_mask);

        return $this;
    }

    public function substr(int $start,  ? int $length = null) : self {
        if (is_null($length)) {
            $this->str = substr($this->str, $start);
        } else {
            $this->str = substr($this->str, $start, $length);
        }

        return $this;
    }

    public function strlen() {
        return strlen($this->str);
    }

    public function __toString() {
        return $this->str;
    }

    public function strtolower() {
        $this->str = strtolower($this->str);

        return $this;
    }

    public function strtoupper() {
        $this->str = strtoupper($this->str);

        return $this;
    }
}