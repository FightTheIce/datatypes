<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Pseudo;

use FightTheIce\Datatypes\Core\Contracts\NumberInterface;
use FightTheIce\Datatypes\Core\Contracts\PseudoNumberInterface;
use Illuminate\Support\Traits\Macroable;
use FightTheIce\Datatypes\Core\Contracts\BooleanInterface;
use FightTheIce\Datatypes\Core\Contracts\FloatInterface;
use FightTheIce\Datatypes\Core\Contracts\IntegerInterface;
use FightTheIce\Datatypes\Scalar\Boolean_;
use FightTheIce\Datatypes\Scalar\Integer_;
use FightTheIce\Datatypes\Scalar\Float_;
use FightTheIce\Exceptions\InvalidArgumentException;
use Brick\Math\BigNumber;

class Number_ implements NumberInterface, PseudoNumberInterface
{
    use Macroable;

    /**
     * concrete
     * Concrete string class.
     *
     * @var NumberInterface
     */
    protected NumberInterface $concrete;

    /**
     * __construct.
     *
     * @param mixed $num
     */
    public function __construct($num = 0)
    {
        if (is_int($num)) {
            $this->concrete = new Integer_($num);
        } elseif (is_float($num)) {
            $this->concrete = new Float_($num);
        } else {
            $exception = new InvalidArgumentException('Parameter $num is expected to be a float or int');
            $exception->setComponentName('datatypes');

            throw $exception;
        }
    }

    public function is_float(): BooleanInterface
    {
        return new Boolean_(($this->concrete instanceof Float_));
    }

    public function is_integer(): BooleanInterface
    {
        return new Boolean_(($this->concrete instanceof Integer_));
    }

    public function resolve(): NumberInterface
    {
        return $this->concrete;
    }

    public function getPrimitiveType(): string
    {
        return 'number';
    }

    public function getDatatypeCategory(): string
    {
        return 'pseudo';
    }

    public function describe(): string
    {
        return $this->concrete->describe();
    }

    public function isPositive(): BooleanInterface
    {
        return $this->concrete->isPositive();
    }

    public function isNegative(): BooleanInterface
    {
        return $this->concrete->isNegative();
    }

    public function isZero(): BooleanInterface
    {
        return $this->concrete->isZero();
    }

    /**
     * getNumber.
     *
     * @return int|float|string
     */
    public function getNumber()
    {
        return $this->concrete->getNumber();
    }

    public function __toFloat(): FloatInterface
    {
        return $this->concrete->__toFloat();
    }

    public function __toInteger(): IntegerInterface
    {
        return $this->concrete->__toInteger();
    }

    public function absolute(): NumberInterface
    {
        return new self($this->concrete->absolute()->getNumber());
    }

    public function negated(): NumberInterface
    {
        return new self($this->concrete->negated()->getNumber());
    }

    public function negativeabsolute(): NumberInterface
    {
        return new self($this->concrete->negativeabsolute()->getNumber());
    }

    public function math(): BigNumber
    {
        return $this->concrete->math();
    }
}
