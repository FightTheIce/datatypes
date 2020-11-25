<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Scalar;

use Thunder\Nevar\Nevar;
use FightTheIce\Datatypes\Core\Contracts\UnicodeStringInterface;
use Illuminate\Support\Traits\Macroable;
use function Symfony\Component\String\s;
use Symfony\Component\String\AbstractString;
use FightTheIce\Datatypes\Core\Contracts\BooleanInterface;
use FightTheIce\Datatypes\Core\Contracts\StringInterface;
use FightTheIce\Datatypes\Core\Contracts\IntegerInterface;
use FightTheIce\Datatypes\Core\Contracts\ArrayInterface;
use FightTheIce\Datatypes\Compound\Array_;
use ArrayAccess;
use FightTheIce\Exceptions\LogicException;

class UnicodeString_ implements UnicodeStringInterface, ArrayAccess
{
    use Macroable;

    protected AbstractString $value;

    public function __construct(string $value = '')
    {
        $this->value = s($value);
    }

    public function getDatatypeCategory(): string
    {
        return 'scalar';
    }

    public function describe(): string
    {
        return Nevar::describe($this->value->__toString());
    }

    public function getPrimitiveType(): string
    {
        return 'string';
    }

    public function __toString(): string
    {
        return $this->value->__toString();
    }

    /**
     * ltrim
     * Strip whitespace (or other characters) from the beginning of a string.
     *
     * @see https://www.php.net/manual/en/function.ltrim.php
     *
     * @param string $character_mask
     *
     * @return StringInterface
     */
    public function ltrim(string $character_mask = " \t\n\r\0\x0B\x0C\u{A0}\u{FEFF}"): StringInterface
    {
        return new self($this->value->trimStart($character_mask)->__toString());
    }

    /**
     * rtrim
     * Strip whitespace (or other characters) from the end of a string.
     *
     * @see https://www.php.net/manual/en/function.rtrim.php
     *
     * @param string $character_mask
     *
     * @return StringInterface
     */
    public function rtrim(string $character_mask = " \t\n\r\0\x0B\x0C\u{A0}\u{FEFF}"): StringInterface
    {
        return new self($this->value->trimEnd($character_mask)->__toString());
    }

    /**
     * trim
     * Strip whitespace (or other characters) from the beginning and end of a string.
     *
     * @see https://www.php.net/manual/en/function.trim.php
     *
     * @param string $character_mask
     *
     * @return StringInterface
     */
    public function trim(string $character_mask = " \t\n\r\0\x0B\x0C\u{A0}\u{FEFF}"): StringInterface
    {
        return new self($this->value->trim($character_mask)->__toString());
    }

    /**
     * substr
     * Return part of a string.
     *
     * @see https://www.php.net/manual/en/function.substr.php
     *
     * @param int      $start
     * @param int|null $length
     *
     * @return StringInterface
     */
    public function substr(int $start, ? int $length = null): StringInterface
    {
        return new self($this->value->slice($start, $length)->__toString());
    }

    /**
     * strtolower
     * Make a string lowercase.
     *
     * @see https://www.php.net/manual/en/function.strtolower.php
     *
     * @return StringInterface
     */
    public function strtolower(): StringInterface
    {
        return new self($this->value->lower()->__toString());
    }

    /**
     * strtoupper
     * Make a string uppercase.
     *
     * @see https://www.php.net/manual/en/function.strtoupper.php
     *
     * @return StringInterface
     */
    public function strtoupper(): StringInterface
    {
        return new self($this->value->upper()->__toString());
    }

    public function isEmpty(): BooleanInterface
    {
        return new Boolean_($this->value->isEmpty());
    }

    /**
     * strlen
     * Get string length.
     *
     * @see https://www.php.net/manual/en/function.strlen.phps
     *
     * @return IntegerInterface
     */
    public function strlen(): IntegerInterface
    {
        return new Integer_($this->value->length());
    }

    /**
     * str_split
     * Convert a string to an array.
     *
     * @see https://www.php.net/manual/en/function.str-split.php
     *
     * @param int|int $split_length
     * @psalm-suppress InvalidArgument
     *
     * @return ArrayInterface
     */
    public function str_split(int $split_length = 1): ArrayInterface
    {
        $split = $this->value->chunk($split_length);
        //because UnicodeString returns an array of objects we have to convert them to just strings
        //if this is possible?
        foreach ($split as $key => &$value) {
            $value = $value->__toString();
        }

        return new Array_($split);
    }

    public function offsetExists($offset): bool
    {
        $x = $this->__toString();

        return isset($x[$offset]);
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
        //here just to throw an exception for keys
        //not actually used to build the new string
        $str          = $this->__toString();
        $str[$offset] = $value;

        $explode = $this->str_split()->__toArray();
        if (!isset($explode[$offset])) {
            for ($a=count($explode); $a < $offset; $a++) {
                $explode[$a] = ' ';
            }
        }

        $explode[$offset] = $value;
        self::__construct(implode('', $explode));
    }

    public function offsetUnset($offset): void
    {
        if ($this->offsetExists($offset) == false) {
            $exception = new LogicException('Undefined offset!');
            $exception->setComponentName('datatypes');

            throw $exception;
        }

        $x = $this->str_split()->__toArray();
        unset($x[$offset]);

        self::__construct(implode('', $x));
    }
}
