<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Scalar;

use Thunder\Nevar\Nevar;
use FightTheIce\Datatypes\Core\Contracts\StringInterface;
use Illuminate\Support\Traits\Macroable;
use FightTheIce\Exceptions\UnexpectedValueException;
use FightTheIce\Datatypes\Core\Contracts\BooleanInterface;
use FightTheIce\Datatypes\Core\Contracts\IntegerInterface;
use FightTheIce\Datatypes\Core\Contracts\ArrayInterface;
use FightTheIce\Datatypes\Compound\Array_;
use ArrayAccess;
use FightTheIce\Exceptions\LogicException;
use Dont\DontGet;
use Dont\DontSet;

class String_ implements StringInterface, ArrayAccess
{
    use Macroable;
    use DontGet;
    use DontSet;

    protected string $value = '';

    public function __construct(string $value = '')
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
        return 'string';
    }

    public function __toString(): string
    {
        return $this->value;
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
    public function ltrim(string $character_mask = " \t\n\r\0\x0B"): StringInterface
    {
        return new self(ltrim($this->value, $character_mask));
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
    public function rtrim(string $character_mask = " \t\n\r\0\x0B"): StringInterface
    {
        return new self(rtrim($this->value, $character_mask));
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
    public function trim(string $character_mask = " \t\n\r\0\x0B"): StringInterface
    {
        return new self(trim($this->value, $character_mask));
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
        $test = '';
        if ($length === null) {
            $test = substr($this->value, $start);
        } else {
            $test = substr($this->value, $start, $length);
        }

        /* @phpstan-ignore-line */ if ($test === false) {
            $exception = new UnexpectedValueException('Unexpected boolean value.');
            $exception->setComponentName('datatypes');

            throw $exception;
        }

        return new self($test);
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
        return new self(strtolower($this->value));
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
        return new self(strtoupper($this->value));
    }

    /**
     * isEmpty
     * Determine whether a variable is empty.
     *
     * @see https://www.php.net/manual/en/function.empty.php
     *
     * @return BooleanInterface
     */
    public function isEmpty(): BooleanInterface
    {
        return new Boolean_(empty($this->value));
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
        return new Integer_(strlen($this->value));
    }

    /**
     * str_split
     * Convert a string to an array.
     *
     * @see https://www.php.net/manual/en/function.str-split.php
     *
     * @param int|int $split_length
     *
     * @return ArrayInterface
     */
    public function str_split(int $split_length = 1): ArrayInterface
    {
        //we are going stfu the str_split error if there is one so we get false back
        $split = @str_split($this->value, $split_length);

        if ($split == false) {
            $exception = new UnexpectedValueException('str_split resulted in a boolean value');
            $exception->setComponentName('datatypes');

            throw $exception;
        }

        if (count($split) == 1) {
            if (strlen($split[0]) == 0) {
                $split = [];
            }
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
