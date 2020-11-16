<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Pseudo;

use FightTheIce\Datatypes\Core\Contracts\StringInterface;
use FightTheIce\Datatypes\Scalar\UnicodeString_;
use FightTheIce\Datatypes\Scalar\String_ as NonUnicodeString_;
use Illuminate\Support\Traits\Macroable;
use FightTheIce\Datatypes\Core\Contracts\ResolvableInterface;
use ArrayAccess;
use FightTheIce\Datatypes\Scalar\Boolean_;
use FightTheIce\Datatypes\Scalar\Integer_;

class String_ implements ArrayAccess, StringInterface, ResolvableInterface
{
    use Macroable;

    protected StringInterface $class;
    protected bool $isUnicode = false;

    public function __construct(string $str = '')
    {
        if (strlen($str) != strlen(utf8_decode($str))) {
            //unicode
            $this->class     = new UnicodeString_($str);
            $this->isUnicode = true;
        } else {
            //no unicode
            $this->class    = new NonUnicodeString_($str);
            $this->isUnicode= false;
        }
    }

    public function isUnicode(): Boolean_
    {
        return new Boolean_($this->isUnicode);
    }

    public function getDatatypeClass(): StringInterface
    {
        return $this->class;
    }

    /**
     * strlen
     * Get string length.
     *
     * @see https://www.php.net/manual/en/function.strlen.php
     *
     * @return Integer_
     */
    public function strlen(): Integer_
    {
        return $this->class->strlen();
    }

    /**
     * str_split
     * Convert a string to an array.
     *
     * @see https://www.php.net/manual/en/function.str-split.php
     *
     * @param int|int $split_length
     *
     * @return array
     */
    public function str_split(int $split_length = 1): array
    {
        return $this->class->str_split($split_length);
    }

    /**
     * __toString
     * method allows a class to decide how it will react when it is treated like a string.
     *
     * @see https://www.php.net/manual/en/language.oop5.magic.php#object.tostring
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->class->__toString();
    }

    /**
     * isEmpty
     * Determine whether the value is empty.
     *
     * @see https://www.php.net/manual/en/function.empty.php
     *
     * @return Boolean_
     */
    public function isEmpty(): Boolean_
    {
        return $this->class->isEmpty();
    }

    /**
     * strtoupper
     * Make a string uppercase.
     *
     * @see https://www.php.net/manual/en/function.strtoupper.php
     *
     * @return String_
     */
    public function strtoupper(): String_
    {
        return new self($this->class->strtoupper()->__toString());
    }

    /**
     * strtolower
     * Make a string lowercase.
     *
     * @see https://www.php.net/manual/en/function.strtolower.php
     *
     * @return String_
     */
    public function strtolower(): String_
    {
        return new self($this->class->strtolower()->__toString());
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
     * @return String_
     */
    public function substr(int $start, ? int $length = null): String_
    {
        return new self($this->class->substr($start, $length)->__toString());
    }

    /**
     * trim
     * Strip whitespace (or other characters) from the beginning and end of a string.
     *
     * @see https://www.php.net/manual/en/function.trim.php
     *
     * @param string $character_mask
     *
     * @return String_
     */
    public function trim(string $character_mask = " \t\n\r\0\x0B"): String_
    {
        return new self($this->class->trim($character_mask)->__toString());
    }

    /**
     * rtrim
     * Strip whitespace (or other characters) from the end of a string.
     *
     * @see https://www.php.net/manual/en/function.rtrim.php
     *
     * @param string $character_mask
     *
     * @return String_
     */
    public function rtrim(string $character_mask = " \t\n\r\0\x0B"): String_
    {
        return new self($this->class->rtrim($character_mask)->__toString());
    }

    /**
     * ltrim
     * Strip whitespace (or other characters) from the beginning of a string.
     *
     * @see https://www.php.net/manual/en/function.ltrim.php
     *
     * @param string $character_mask
     *
     * @return String_
     */
    public function ltrim(string $character_mask = " \t\n\r\0\x0B"): String_
    {
        return new self($this->class->ltrim($character_mask)->__toString());
    }

    public function getValue(): string
    {
        return $this->class->getValue();
    }

    /**
     * offsetUnset
     * Unset an offset.
     *
     * @see https://www.php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset): void
    {
        $this->class->offsetUnset($offset);
        self::__construct($this->class->__toString());
    }

    /**
     * offsetSet
     * Assign a value to the specified offset.
     *
     * @see https://www.php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        $this->class->offsetSet($offset, $value);
        self::__construct($this->class->__toString());
    }

    /**
     * offsetGet
     * Offset to retrieve.
     *
     * @see https://www.php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->class->offsetGet($offset);
    }

    /**
     * offsetExists
     * Whether an offset exists.
     *
     * @see https://www.php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return $this->class->offsetExists($offset);
    }

    /**
     * resolve
     * Resolve the concrete string class.
     *
     * @return StringInterface
     */
    public function resolve()
    {
        return $this->class;
    }
}
