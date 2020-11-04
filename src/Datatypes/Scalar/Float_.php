<?php
declare (strict_types = 1);

namespace FightTheIce\Datatypes\Scalar;

use FightTheIce\Datatypes\Core\Datatype;
use Illuminate\Support\Traits\Macroable;

class Float_ implements Datatype
{
    use Macroable;

    protected $value = 0.00;

    public function __construct(float $value = 0.00)
    {
        $this->value = $value;
    }

    /**
     * @return float
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
            new self(0 - $this->value);
        }

        return $this->absolute();
    }
}
