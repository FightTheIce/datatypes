<?php

namespace FightTheIce\Datatypes\Datatype;

use FightTheIce\Datatypes\Core\DataTypeInterface;
use FightTheIce\Datatypes\Core\Macroable;
use FightTheIce\Datatypes\Core\StringInterface;
use Symfony\Component\String\ByteString;
use Symfony\Component\String\UnicodeString;

class Utf8String_ implements DataTypeInterface, StringInterface {
    protected $str = null;

    public function __construct(string $str) {
        //$this->str = new UnicodeString($str);
        $this->str = preg_match('//u', $str) ? new UnicodeString($str) : new ByteString($str);
    }

    public function trim(string $character_mask = " \t\n\r\0\x0B"): self{
        $this->str = $this->str->trim($character_mask);

        return $this;
    }

    public function ltrim(string $character_mask = " \t\n\r\0\x0B"): self{
        $this->str = $this->str->trimStart($character_mask);

        return $this;
    }

    public function rtrim(string $character_mask = " \t\n\r\0\x0B"): self{
        $this->str = $this->str->trimEnd($character_mask);

        return $this;
    }

    public function substr(int $start,  ? int $length = null) : self{
        $this->str = $this->str->slice($start, $length);

        return $this;
    }

    public function strlen() {
        return $this->str->length();
    }

    public function __toString() {
        return $this->str->__toString();
    }

    public function toAscii() {
        $str       = new UnicodeString($this->str);
        $this->str = $str->ascii();

        return $this;
    }

    public function isUtf8() {
        $str = new ByteString($this->str);

        return $str->isUtf8();
    }
}