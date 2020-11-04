<?php
declare (strict_types = 1);

namespace FightTheIce\Datatypes\Scalar;

use FightTheIce\Datatypes\Core\Datatype;
use Illuminate\Support\Traits\Macroable;

class Boolean_ implements Datatype
{
    use Macroable;

    protected $value = false;

    public function __construct(bool $value = false)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function isTrue(bool $strict = false)
    {
        if ($strict == true) {
            return $this->isStrictTrue();
        }

        if ($this->value == true) {
            return true;
        }

        return false;
    }

    public function isFalse(bool $strict = false)
    {
        return !$this->isTrue($strict);
    }

    public function isStrictTrue()
    {
        if ($this->value === true) {
            return true;
        }

        return false;
    }

    public function isStrictFalse()
    {
        return !$this->isStrictFalse();
    }

    public function inverse()
    {
        return new self(!$this->value);
    }

    public function transform(string $true, string $false, bool $strict = true): string
    {
        if ($this->isTrue($strict)) {
            return $true;
        }

        return $false;
    }
}
