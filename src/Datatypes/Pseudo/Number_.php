<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Pseudo;

use FightTheIce\Datatypes\Scalar\Float_;
use FightTheIce\Datatypes\Scalar\Integer_;
use Illuminate\Support\Traits\Macroable;
use FightTheIce\Exceptions\InvalidArgumentException;
use FightTheIce\Datatypes\Scalar\Boolean_;
use Brick\Math\BigNumber;
use FightTheIce\Datatypes\Core\Contracts\MathInterface;

class Number_ implements MathInterface
{
    use Macroable;

    protected MathInterface $class;

    /**
     * __construct.
     *
     * @param mixed $number
     *
     */
    public function __construct($number = 0)
    {
        if ($number instanceof MathInterface) {
            $number = $number->getValue();
        }

        if (!is_numeric($number)) {
            $exception = new InvalidArgumentException('Only numbers are allowed.');
            $exception->setComponentName('datatypes');
            throw $exception;
        }

        if (is_float($number + 0) == true) {
            $this->class  = new Float_(floatval($number));
        } elseif (is_int($number + 0) == true) {
            $this->class  = new Integer_(intval($number));
        } else {
            $exception = new InvalidArgumentException('Unable to determine number type.');
            $exception->setComponentName('datatypes');
            throw $exception;
        }
    }

    /**
     * @return int|float
     */
    public function getValue()
    {
        return $this->class->getValue();
    }

    public function isPositive(): Boolean_
    {
        return $this->class->isPositive();
    }

    public function isNegative(): Boolean_
    {
        return $this->class->isNegative();
    }

    public function absolute(): self
    {
        return new self($this->class->absolute()->getValue());
    }

    public function opposite(): self
    {
        return new self($this->class->opposite()->getValue());
    }

    public function math(): BigNumber
    {
        return $this->class->math();
    }

    public function __toString(): string
    {
        return $this->class->__toString();
    }

    public function __toFloat(): self
    {
        return new self($this->class->__toFloat());
    }

    public function __toInteger(): self
    {
        return new self($this->class->__toInteger());
    }

    public function getDatatypeClass(): MathInterface
    {
        return $this->class;
    }

    public function resolve(): MathInterface
    {
        return $this->class;
    }

    public function isInteger(): Boolean_
    {
        return new Boolean_(($this->class instanceof Integer_));
    }

    public function isFloat(): Boolean_
    {
        return new Boolean_(($this->class instanceof Float_));
    }
}
