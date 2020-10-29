<?php
declare (strict_types = 1);

namespace FightTheIce\Datatypes\Datatype;
use ArrayAccess;
use FightTheIce\Datatypes\Core\Interfaces\DatatypeInterface;
use FightTheIce\Datatypes\Core\Interfaces\StringInterface;
use Illuminate\Support\Traits\Macroable;

class String_ implements DatatypeInterface, ArrayAccess, StringInterface {
    use Macroable;

    protected $value = '';

    public function __construct(string $value = '') {
        $this->value = $value;
    }

    public function __toString(): string {
        return $this->value;
    }

    public function trim($character_mask = " \t\n\r\0\x0B"): self{
        $this->value = trim($this->value, $character_mask);

        return $this;
    }

    public function ltrim($character_mask = " \t\n\r\0\x0B"): self{
        $this->value = ltrim($this->value, $character_mask);

        return $this;
    }

    public function rtrim($character_mask = " \t\n\r\0\x0B"): self{
        $this->value = rtrim($this->value, $character_mask);

        return $this;
    }

    public function strtoupper(): self{
        $this->value = strtoupper($this->value);

        return $this;
    }

    public function strtolower(): self{
        $this->value = strtolower($this->value);

        return $this;
    }

    public function substr(int $start,  ? int $length = null) : self {
        if ($length === null) {
            $this->value = substr($this->value, $start);

            return $this;
        }

        $this->value = substr($this->value, $start, $length);
        return $this;
    }

    public function strlen() {
        return strlen($this->value);
    }

    public function refresh(string $value = '') {
        self::__construct($value);

        return $this;
    }

    public function getType(): string {
        return 'string';
    }

    public function getValue() {
        return $this->value;
    }

    public function offsetExists($offset): bool {
        //convert string to array and check offset

        return isset($this->value[$offset]);
    }

    public function offsetGet($offset) {
        //check if offset exists and return it
        //otherwise return null
        if (isset($this->value[$offset])) {
            return $this->value[$offset];
        }

        throw new \ErrorException('offset: ' . $offset . ' does not exists!');
    }

    public function offsetSet($offset, $value): void{
        //copy the string as an array
        $array = str_split($this->value, 1);
        $count = count($array);

        //string split will return an array element even if there was
        //an empty string
        if ($count == 1) {
            if (empty($array[0])) {
                $array = array();
                $count = 0;
            }
        }

        //i don't think we are going to allow this one? but maybe?
        if ($offset === null) {
            throw new \ErrorException('offset must not be null');
        }

        if (!is_numeric($offset)) {
            throw new \ErrorException('offset must be a numeric value');
        }

        if ($count == 0) {
            if ($offset !== $count) {
                throw new \ErrorException('No data so first key may only be 0');
            }
        }

        if (floor($offset) == $offset && ceil($offset) == $offset) {
            //this is good continue
        } else {
            throw new \ErrorException('offset must be a whole number');
        }

        if ($offset < 0) {
            throw new \ErrorException('offset must be greater or equal to 0');
        }

        if ($offset >= $count + 1) {
            throw new \ErrorException('offset is far to large');
        }

        //now update the existing array
        $array[$offset] = $value;

        $this->refresh(implode('', $array));
    }

    public function offsetUnset($offset): void {
        if ($this->offsetExists($offset) == false) {
            throw new \ErrorException('offset: ' . $offset . ' does not exists!');
        }

        //copy the string as an array
        $array = str_split($this->value, 1);

        //now update the existing array
        $array[$offset] = $value;

        unset($array[$offset]);

        $this->refresh(implode('', $array));
    }
}