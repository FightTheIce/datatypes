<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Scalar;

use FightTheIce\Datatypes\Core\Contracts\DatatypeInterface;
use FightTheIce\Datatypes\Core\Contracts\MathInterface;
use Illuminate\Support\Traits\Macroable;
use Brick\Math\BigInteger;

class Integer_ implements DatatypeInterface, MathInterface
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

    public function isPositive(): Boolean_
    {
        if ($this->value >= 0) {
            return new Boolean_(true);
        }

        return new Boolean_(false);
    }

    public function isNegative(): Boolean_
    {
        if ($this->value < 0) {
            return new Boolean_(true);
        }

        return new Boolean_(false);
    }

    public function absolute(): self
    {
        return new self(abs($this->value));
    }

    public function opposite(): self
    {
        return new self($this->math()->negated()->toInt());
    }

    public function math(): BigInteger
    {
        return BigInteger::of($this->value);
    }

    public function __toString(): string
    {
        return $this->math()->__toString();
    }

    public function __toFloat(): Float_
    {
        return new Float_($this->math()->toFloat());
    }

    public function __toInteger(): self
    {
        return new self($this->value);
    }
}
