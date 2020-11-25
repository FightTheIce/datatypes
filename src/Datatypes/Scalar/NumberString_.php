<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Scalar;

use FightTheIce\Datatypes\Core\Contracts\NumberStringInterface;
use FightTheIce\Datatypes\Core\Contracts\StringInterface;
use FightTheIce\Datatypes\Core\Contracts\IntegerInterface;
use FightTheIce\Datatypes\Core\Contracts\FloatInterface;
use Illuminate\Support\Traits\Macroable;
use FightTheIce\Exceptions\InvalidArgumentException;
use Brick\Math\BigRational;
use Brick\Math\BigNumber;
use FightTheIce\Datatypes\Core\Contracts\BooleanInterface;
use FightTheIce\Datatypes\Core\Contracts\ArrayInterface;
use FightTheIce\Datatypes\Core\Contracts\NumberInterface;
use FightTheIce\Exceptions\ArithmeticError;
use ArrayAccess;
use FightTheIce\Exceptions\LogicException;

class NumberString_ implements NumberStringInterface, IntegerInterface, FloatInterface, ArrayAccess
{
    use Macroable;

    protected StringInterface $str;

    public function __construct(string $value = '0')
    {
        if (strlen($value) == 0) {
            $value = '0';
        }

        $value = str_replace('_', '', $value);
        $value = str_replace(',', '', $value);
        $value = str_replace(' ', '', $value);
        $value = ltrim($value, ' ');
        $value = rtrim($value, ' ');

        if (substr($value, 0, 1) == '0') {
            $value = '0' . ltrim($value, '0');
        }

        if (substr($value, 0, 2) == '0x') {
            //this means is a hex so we need to decode
            $value = hex2bin(substr($value, 2));
        } elseif (substr($value, 0, 2) == '0b') {
            //this means binary
            $str   = substr($value, 2);
            $float = floatval($str);
            $value = (string) bindec((string) $float);
        } elseif (substr($value, 0, 1) == '0') {
            //this means octal
            $value = substr($value, 1);
            $value = octdec((string) $value);
            $value = (string) $value;
        }

        if (!is_numeric($value)) {
            $exception = new InvalidArgumentException('The param $value must be a numeric string');
            $exception->setComponentName('datatypes');

            throw $exception;
        }

        $this->str = new String_($value);
    }

    public function __toString(): string
    {
        return (BigRational::of($this->str->__toString()))->__toString();
    }

    public function ltrim(string $character_mask = " \t\n\r\0\x0B"): StringInterface
    {
        return new self($this->str->ltrim($character_mask)->__toString());
    }

    public function rtrim(string $character_mask = " \t\n\r\0\x0B"): StringInterface
    {
        return new self($this->str->rtrim($character_mask)->__toString());
    }

    public function trim(string $character_mask = " \t\n\r\0\x0B"): StringInterface
    {
        return new self($this->str->trim($character_mask)->__toString());
    }

    public function substr(int $start, ? int $length = null): StringInterface
    {
        $value = $this->str->substr($start, $length);
        file_put_contents('coverage/log7.txt', print_r($value, true));

        return new self($this->str->substr($start, $length)->__toString());
    }

    public function strtolower(): StringInterface
    {
        return new self($this->str->strtolower()->__toString());
    }

    public function strtoupper(): StringInterface
    {
        return new self($this->str->strtoupper()->__toString());
    }

    public function isEmpty(): BooleanInterface
    {
        return $this->str->isEmpty();
    }

    public function strlen(): IntegerInterface
    {
        return $this->str->strlen();
    }

    public function str_split(int $split_length = 1): ArrayInterface
    {
        return $this->str->str_split($split_length);
    }

    public function getPrimitiveType(): string
    {
        return 'string';
    }

    public function getDatatypeCategory(): string
    {
        return 'scalar';
    }

    public function describe(): string
    {
        return $this->str->describe();
    }

    public function isPositive(): BooleanInterface
    {
        return new Boolean_((BigRational::of($this->__toString()))->isPositive());
    }

    public function isNegative(): BooleanInterface
    {
        return new Boolean_((BigRational::of($this->__toString()))->isNegative());
    }

    public function isZero(): BooleanInterface
    {
        return new Boolean_((BigRational::of($this->__toString()))->isZero());
    }

    /**
     * getNumber.
     *
     * @return int|float|string
     */
    public function getNumber()
    {
        return $this->__toString();
    }

    public function __toFloat(): FloatInterface
    {
        if ($this->is_string_float()->isTrue() == true) {
            return new Float_((BigRational::of($this->__toString()))->toFloat());
        }

        $exception = new ArithmeticError('Unable to convert string to float');
        $exception->setComponentName('datatypes');

        throw $exception;
    }

    public function __toInteger(): IntegerInterface
    {
        if ($this->is_string_integer()->isTrue() == true) {
            return new Integer_((BigRational::of($this->__toString()))->toInt());
        }

        $exception = new ArithmeticError('Unable to convert string to integer');
        $exception->setComponentName('datatypes');

        throw $exception;
    }

    public function absolute(): NumberInterface
    {
        return new self((BigRational::of($this->str->__toString()))->abs()->__toString());
    }

    public function negated(): NumberInterface
    {
        return new self((BigRational::of($this->str->__toString()))->negated()->__toString());
    }

    public function negativeabsolute(): NumberInterface
    {
        return new self((BigRational::of($this->str->__toString()))->abs()->negated()->__toString());
    }

    public function math(): BigNumber
    {
        return BigRational::of($this->str->__toString());
    }

    public function is_string_float(): BooleanInterface
    {
        $pos = strpos($this->__toString(), '/');
        if (!$pos) {
            return new Boolean_(false);
        }

        return new Boolean_(true);
    }

    public function is_string_integer(): BooleanInterface
    {
        $pos = strpos($this->__toString(), '/');
        if (!$pos) {
            return new Boolean_(true);
        }

        return new Boolean_(false);
    }

    public function offsetExists($offset): bool
    {
        return $this->str->offsetExists($offset);
    }

    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset) == false) {
            $exception = new LogicException('Undefined offset!');
            $exception->setComponentName('datatypes');

            throw $exception;
        }

        $character = $this->substr($offset, 1);

        return new self($character->__toString());
    }

    public function offsetSet($offset, $value): void
    {
        $this->str->offsetSet($offset, $value);
        self::__construct($this->str->__toString());
    }

    public function offsetUnset($offset): void
    {
        $this->str->offsetUnset($offset);
        self::__construct($this->str->__toString());
    }
}
