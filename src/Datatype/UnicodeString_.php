<?php
declare (strict_types = 1);

namespace FightTheIce\Datatypes\Datatype;
use FightTheIce\Datatypes\Core\Interfaces\DatatypeInterface;
use FightTheIce\Datatypes\Core\Interfaces\StringInterface;
use Illuminate\Support\Traits\Macroable;
use Symfony\Component\String\ByteString;
use Symfony\Component\String\UnicodeString;

class UnicodeString_ implements DatatypeInterface, StringInterface {
    use Macroable;

    protected $value = '';

    public function __construct(string $value = '') {
        $this->value = preg_match('//u', $value) ? new UnicodeString($value) : new ByteString($value);
    }

    public function getType(): string {
        return 'string';
    }

    public function getValue(): string {
        return $this->value->__toString();
    }

    public function __toString(): string {
        return $this->value->__toString();
    }

    public function ltrim($character_mask = " \t\n\r\0\x0B\x0C\u{A0}\u{FEFF}"): self {
        return $this->refresh($this->value->trimStart($character_mask));
    }

    public function rtrim($character_mask = " \t\n\r\0\x0B\x0C\u{A0}\u{FEFF}"): self {
        return $this->refresh($this->value->trimEnd($character_mask));
    }

    public function strtoupper(): self {
        return $this->refresh($this->value->upper());
    }

    public function strtolower(): self {
        return $this->refresh($this->value->lower());
    }

    public function substr(int $start,  ? int $length = null) : self {
        if ($length === null) {
            //now length was included
            return $this->refresh($this->value->slice($start));
        }

        return $this->refresh($this->value->slice($start, $length));
    }

    public function strlen() {
        return $this->value->length();
    }

    public function trim($character_mask = " \t\n\r\0\x0B\x0C\u{A0}\u{FEFF}") {
        return $this->refresh($this->value->trim($character_mask));
    }

    public function refresh(string $value = '') {
        self::__construct($value);

        return $this;
    }
}