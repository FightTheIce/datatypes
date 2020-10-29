<?php

namespace FightTheIce\Datatypes\Datatype;

use FightTheIce\Datatypes\Core\Interfaces\DatatypeInterface;

class Float_ implements DatatypeInterface {
    protected $value;

    public function __construct(float $value = 0) {
        $this->value = $value;
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
        return 'float';
    }

    public function getValue() {
        return $this->value;
    }
}