<?php

namespace FightTheIce\Datatypes\Datatype;

use FightTheIce\Datatypes\Core\Interfaces\DatatypeInterface;

class Integer_ implements DatatypeInterface {
    protected $value;

    public function __construct(int $value = 0) {
        $this->value = $value;
    }

    public function getDecimal(): int {
        return $this->value;
    }

    public function getOctal(): string {
        return decoct($this->value);
    }

    public function getOctalString(): string {
        return '0' . $this->getOctal();
    }

    public function getHexadecimal(): string {
        return dechex($this->value);
    }

    public function getHexadecimalString(): string {
        return '0x' . $this->getHexadecimal();
    }

    public function getBinary(): string {
        return decbin($this->value);
    }

    public function getBinaryString(): string {
        return '0b' . $this->getBinary();
    }

    public function isPositive(): bool {
        if ($this->value >= 0) {
            return true;
        }

        return false;
    }

    public function isNegative(): bool {
        if ($this->value < 0) {
            return true;
        }

        return false;
    }

    public function absolute(): self{
        $this->value = abs($this->value);

        return $this;
    }

    public function opposite(): self {
        if ($this->isPositive() == true) {
            $this->value = 0 - $this->value;

            return $this;
        }

        return $this->absolute();
    }

    public function getType(): string {
        return 'integer';
    }

    public function getValue() {
        return $this->value;
    }

    public function isGreaterThan(int $compare): bool {
        if ($this->value > $compare) {
            return true;
        }

        return false;
    }

    public function isLessThan(int $compare): bool {
        if ($this->value < $compare) {
            return true;
        }

        return false;
    }

    public function isEqualTo(int $compare): bool {
        if ($this->value == $compare) {
            return true;
        }

        return false;
    }
}