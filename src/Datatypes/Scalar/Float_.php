<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Scalar;

use FightTheIce\Datatypes\Core\Contracts\FloatInterface;
use Thunder\Nevar\Nevar;
use Illuminate\Support\Traits\Macroable;
use FightTheIce\Datatypes\Core\Contracts\BooleanInterface;
use FightTheIce\Datatypes\Core\Contracts\IntegerInterface;
use Brick\Math\BigDecimal;
use FightTheIce\Datatypes\Core\Contracts\NumberInterface;
use Brick\Math\BigNumber;
use Dont\DontGet;
use Dont\DontSet;
use FightTheIce\Datatypes\Core\Traits\PreventConstructorFromRunningTwice;

class Float_ implements FloatInterface
{
    use Macroable;
    use DontGet;
    use DontSet;
    use PreventConstructorFromRunningTwice;

    protected float $value = 0.00;

    public function __construct(float $value = 0)
    {
        $this->hasConstructorRun();

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
        return 'float';
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
        return new self($this->value);
    }

    public function __toInteger(): IntegerInterface
    {
        return new Integer_(intval($this->value));
    }

    public function absolute(): NumberInterface
    {
        return new self((BigDecimal::of($this->value))->abs()->toFloat());
    }

    public function negated(): NumberInterface
    {
        return new self((BigDecimal::of($this->value))->negated()->toFloat());
    }

    public function negativeabsolute(): NumberInterface
    {
        return new self((BigDecimal::of($this->value))->abs()->negated()->toFloat());
    }

    public function math(): BigNumber
    {
        return BigDecimal::of($this->value);
    }
}
