<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Scalar;

use FightTheIce\Datatypes\Core\Contracts\DatatypeInterface;
use Illuminate\Support\Traits\Macroable;

class Integer_ implements DatatypeInterface
{
    use Macroable;

    protected int $value = 0;

    public function __construct(int $value = 0)
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    public function isPositive(): bool
    {
        if ($this->value >= 0) {
            return true;
        }

        return false;
    }

    public function isNegative(): bool
    {
        if ($this->value < 0) {
            return true;
        }

        return false;
    }

    public function absolute(): self
    {
        return new self(abs($this->value));
    }

    public function opposite(): self
    {
        if ($this->isPositive() == true) {
            return new self(0 - $this->value);
        }

        return $this->absolute();
    }
}
