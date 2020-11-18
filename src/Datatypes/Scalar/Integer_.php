<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Scalar;

use FightTheIce\Datatypes\Core\Contracts\IntegerInterface;
use Thunder\Nevar\Nevar;
use Illuminate\Support\Traits\Macroable;
use FightTheIce\Datatypes\Core\Contracts\BooleanInterface;
use FightTheIce\Datatypes\Core\Contracts\FloatInterface;
use Brick\Math\BigInteger;
use FightTheIce\Datatypes\Core\Contracts\NumberInterface;
use Brick\Math\BigNumber;

class Integer_ implements IntegerInterface
{
    use Macroable;

    protected int $value = 0;

    public function __construct(int $value = 0)
    {
        $this->value = $value;
    }

    public function getDatatypeCategory(): string
    {
        return 'scalar';
    }

    public function describe(): string
    {
        return Nevar::describe($this->value);
    }

    public function getPrimitiveType(): string
    {
        return 'integer';
    }

    public function isPositive(): BooleanInterface
    {
        if ($this->value > 0) {
            return new Boolean_(true);
        }

        return new Boolean_(false);
    }

    public function isNegative(): BooleanInterface
    {
        if ($this->value < 0) {
            return new Boolean_(true);
        }

        return new Boolean_(false);
    }

    public function isZero(): BooleanInterface
    {
        if ($this->value == 0) {
            return new Boolean_(true);
        }

        return new Boolean_(false);
    }

    public function getNumber()
    {
        return $this->value;
    }

    public function __toFloat(): FloatInterface
    {
        return new Float_(floatval($this->value));
    }

    public function __toInteger(): IntegerInterface
    {
        return new self($this->value);
    }

    public function absolute(): NumberInterface
    {
        return new self((BigInteger::of($this->value))->abs()->toInt());
    }

    public function negated(): NumberInterface
    {
        return new self((BigInteger::of($this->value))->negated()->toInt());
    }

    public function negativeabsolute(): NumberInterface
    {
        return new self((BigInteger::of($this->value))->abs()->negated()->toInt());
    }

    public function math(): BigNumber
    {
        return BigInteger::of($this->value);
    }
}
