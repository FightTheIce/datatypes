<?php

namespace FightTheIce\Datatypes\Datatype;

use FightTheIce\Datatypes\Core\Interfaces\DatatypeInterface;

class Boolean_ implements DatatypeInterface {
    protected $value;

    public function __construct(bool $value = false) {
        $this->value = $value;
    }

    public function isTrue(bool $strict = true): bool {
        if ($strict === true) {
            return $this->isHardTrue();
        }

        return $this->isSoftTrue();
    }

    public function isSoftTrue(): bool {
        if ($this->value == true) {
            return true;
        }

        return false;
    }

    public function isHardTrue(): bool {
        if ($this->value === true) {
            return true;
        }

        return false;
    }

    public function isFalse(bool $strict = true): bool {
        if ($strict === true) {
            return $this->isHardFalse();
        }

        return $this->isSoftFalse();
    }

    public function isSoftFalse(): bool {
        if ($this->value == false) {
            return true;
        }

        return false;
    }

    public function isHardFalse(): bool {
        if ($this->value === false) {
            return true;
        }

        return false;
    }

    public function inverse(): self {
        if ($this->isTrue(true) === true) {
            $this->value = false;
        }

        if ($this->isFalse(true) === true) {
            $this->value = true;
        }

        return $this;
    }

    public function compare(bool $comparator, bool $strict = true): bool {
        if ($strict === true) {
            if ($comparator === $this->value) {
                return true;
            }

            return false;
        }

        if ($comparator == $this->value) {
            return true;
        }

        return false;
    }

    public function transform(string $true, string $false, bool $strict = true): string {
        if ($this->isTrue($strict)) {
            return $true;
        }

        return $false;
    }

    public function getType(): string {
        return 'boolean';
    }

    public function getValue() {
        return $this->value;
    }
}