<?php
declare (strict_types = 1);

namespace FightTheIce\Datatypes\Scalar;

use ArrayAccess;
use Illuminate\Support\Traits\Macroable;
use Stringable;

class String_ implements Stringable, ArrayAccess
{
    use Macroable;

    protected $value = '';

    /**
     * Create a string.
     *
     * @psalm-consistent-constructor
     * @param  string  $value
     * @return void
     */
    public function __construct(string $value = '')
    {
        $this->value = $value;
    }

    /**
     * ltrim
     * Strip whitespace (or other characters) from the beginning of a string
     *
     * @see https://www.php.net/manual/en/function.ltrim.php
     * @param  string $character_mask
     * @return String_
     */
    public function ltrim(string $character_mask = " \t\n\r\0\x0B"): String_
    {
        return new self(ltrim($this->value, $character_mask));
    }

    /**
     * rtrim
     * Strip whitespace (or other characters) from the end of a string
     *
     * @see https://www.php.net/manual/en/function.rtrim.php
     * @param  string $character_mask
     * @return String_
     */
    public function rtrim(string $character_mask = " \t\n\r\0\x0B"): String_
    {
        return new self(rtrim($this->value, $character_mask));
    }

    /**
     * trim
     * Strip whitespace (or other characters) from the beginning and end of a string
     *
     * @see https://www.php.net/manual/en/function.trim.php
     * @param  string $character_mask
     * @return String_
     */
    public function trim(string $character_mask = " \t\n\r\0\x0B"): String_
    {
        return new self(trim($this->value, $character_mask));
    }

    /**
     * substr
     * Return part of a string
     *
     * @see https://www.php.net/manual/en/function.substr.php
     * @param  int      $start
     * @param  int|null $length
     * @return String_
     */
    public function substr(int $start,  ? int $length = null) : String_
    {
        $test = '';
        if ($length === null) {
            $test = substr($this->value, $start);
        } else {
            $test = substr($this->value, $start, $length);
        }

        if ($test == false) {
            throw new \ErrorException(__METHOD__);
        }

        return new self($test);
    }

    /**
     * strtolower
     * Make a string lowercase
     *
     * @see https://www.php.net/manual/en/function.strtolower.php
     * @return String_
     */
    public function strtolower(): String_
    {
        return new self(strtolower($this->value));
    }

    /**
     * strtoupper
     * Make a string uppercase
     *
     * @see https://www.php.net/manual/en/function.strtoupper.php
     * @return String_
     */
    public function strtoupper(): String_
    {
        return new self(strtoupper($this->value));
    }

    /**
     * isEmpty
     * Determine whether the value is empty
     *
     * @see https://www.php.net/manual/en/function.empty.php
     * @return boolean
     */
    public function isEmpty(): bool
    {
        return empty($this->value);
    }

    /**
     * __toString
     * method allows a class to decide how it will react when it is treated like a string.
     *
     * @see https://www.php.net/manual/en/language.oop5.magic.php#object.tostring
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * str_split
     * Convert a string to an array
     *
     * @see https://www.php.net/manual/en/function.str-split.php
     * @param  int|integer $split_length
     * @return array
     */
    public function str_split(int $split_length = 1): array
    {
        $split = str_split($this->value, $split_length);
        if (!is_array($split)) {
            throw new \ErrorException(__METHOD__);
        }

        if (count($split) == 1) {
            if (strlen($split[0]) == 0) {
                $split = array();
            }
        }

        return $split;
    }

    /**
     * strlen
     * Get string length
     *
     * @see https://www.php.net/manual/en/function.strlen.php
     * @return int
     */
    public function strlen(): int
    {
        return strlen($this->value);
    }

    /**
     * offsetExists
     * Whether an offset exists
     *
     * @see https://www.php.net/manual/en/arrayaccess.offsetexists.php
     * @param  mixed $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        $explode = $this->str_split();
        return isset($explode[$offset]);
    }

    /**
     * offsetGet
     * Offset to retrieve
     *
     * @see https://www.php.net/manual/en/arrayaccess.offsetget.php
     * @param  mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset) == false) {
            throw new \ErrorException(__METHOD__);
        }

        $explode = $this->str_split();
        return $explode[$offset];
    }

    /**
     * offsetSet
     * Assign a value to the specified offset
     *
     * @see https://www.php.net/manual/en/arrayaccess.offsetset.php
     * @param  mixed $offset
     * @param  mixed $value
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        if (!is_string($value)) {
            if (is_object($value)) {
                if (($value instanceof Stringable) or method_exists($value, '__toString')) {
                    $value = $value->__toString();
                }
            }

            if (!is_string($value)) {
                throw new \ErrorException(__METHOD__ . ' - 5');
            }
        }

        if (!is_numeric($offset)) {
            throw new \ErrorException(__METHOD__ . ' - 1');
        }

        if ((floor((float) $offset) != $offset) || (ceil((float) $offset) != $offset)) {
            throw new \ErrorException(__METHOD__ . ' - 2');
        }

        $explode = $this->str_split();

        //this one needs some logic....
        if ($this->offsetExists($offset) == true) {

            $explode[$offset] = $value;
            $this->value      = implode('', $explode);
            return;
        }

        //offset may always be equal to zero
        if (($offset == 0) || ($offset == '0')) {
            $explode[0]  = $value;
            $this->value = implode('', $explode);
            return;
        }

        //offset may never be greater than count($explode)+1
        //unless offset 0 isn't set
        if (($this->offsetExists(0) == false) and ($offset > 0)) {
            throw new \ErrorException(__METHOD__ . ' - 4');
        }

        $count = count($explode);
        if ($offset > $count) {
            throw new \ErrorException(__METHOD__ . ' - 3');
        }

        $explode[$offset] = $value;
        $this->value      = implode('', $explode);
        return;
    }

    /**
     * offsetUnset
     * Unset an offset
     *
     * @see https://www.php.net/manual/en/arrayaccess.offsetunset.php
     * @param  mixed $offset
     * @return void
     */
    public function offsetUnset($offset): void
    {
        if ($this->offsetExists($offset) == false) {
            return;
        }

        $explode = $this->str_split();
        unset($explode[$offset]);

        $this->value = implode('', $explode);
    }
}
