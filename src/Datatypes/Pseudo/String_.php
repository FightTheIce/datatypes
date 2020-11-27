<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Pseudo;

use FightTheIce\Datatypes\Core\Contracts\StringInterface;
use FightTheIce\Datatypes\Core\Contracts\ArrayInterface;
use FightTheIce\Datatypes\Core\Contracts\BooleanInterface;
use FightTheIce\Datatypes\Core\Contracts\IntegerInterface;
use FightTheIce\Datatypes\Core\Contracts\PseudoStringInterface;
use Illuminate\Support\Traits\Macroable;
use FightTheIce\Datatypes\Scalar\String_ as StdString_;
use FightTheIce\Datatypes\Scalar\UnicodeString_;
use FightTheIce\Datatypes\Scalar\Boolean_;
use ArrayAccess;
use FightTheIce\Exceptions\LogicException;
use Dont\DontGet;
use Dont\DontSet;

class String_ implements StringInterface, PseudoStringInterface, ArrayAccess
{
    use Macroable;
    use DontGet;
    use DontSet;

    /**
     * concrete
     * Concrete string class.
     *
     * @var StringInterface
     */
    protected StringInterface $concrete;

    public function __construct(string $str = '')
    {
        if (strlen($str) != strlen(utf8_decode($str))) {
            //unicode
            $this->concrete = new UnicodeString_($str);
        } else {
            //no unicode
            $this->concrete = new StdString_($str);
        }
    }

    public function __toString(): string
    {
        return $this->concrete->__toString();
    }

    public function ltrim(?string $character_mask = null): StringInterface
    {
        $character_mask = $this->correct_character_mask($character_mask);

        return new self($this->concrete->ltrim($character_mask)->__toString());
    }

    public function rtrim(?string $character_mask = null): StringInterface
    {
        $character_mask = $this->correct_character_mask($character_mask);

        return new self($this->concrete->rtrim($character_mask)->__toString());
    }

    public function trim(?string $character_mask = null): StringInterface
    {
        $character_mask = $this->correct_character_mask($character_mask);

        return new self($this->concrete->trim($character_mask)->__toString());
    }

    public function substr(int $start, ? int $length = null): StringInterface
    {
        return new self($this->concrete->substr($start, $length)->__toString());
    }

    public function strtolower(): StringInterface
    {
        return new self($this->concrete->strtolower()->__toString());
    }

    public function strtoupper(): StringInterface
    {
        return new self($this->concrete->strtoupper()->__toString());
    }

    public function isEmpty(): BooleanInterface
    {
        return $this->concrete->isEmpty();
    }

    public function strlen(): IntegerInterface
    {
        return $this->concrete->strlen();
    }

    public function str_split(int $split_length = 1): ArrayInterface
    {
        return $this->concrete->str_split($split_length);
    }

    public function is_standard_string(): BooleanInterface
    {
        return new Boolean_(($this->concrete instanceof StdString_));
    }

    public function is_unicode_string(): BooleanInterface
    {
        return new Boolean_(($this->concrete instanceof UnicodeString_));
    }

    protected function correct_character_mask(?string $character_mask = null): string
    {
        if (is_null($character_mask)) {
            $character_mask = '';
            if ($this->is_standard_string()->isTrue() === true) {
                $character_mask = " \t\n\r\0\x0B";
            } else {
                $character_mask = " \t\n\r\0\x0B\x0C\u{A0}\u{FEFF}";
            }
        }

        return $character_mask;
    }

    public function getPrimitiveType(): string
    {
        return 'string';
    }

    public function getDatatypeCategory(): string
    {
        return 'pseudo';
    }

    public function describe(): string
    {
        return $this->concrete->describe();
    }

    public function resolve(): StringInterface
    {
        return $this->concrete;
    }

    public function offsetExists($offset): bool
    {
        return $this->concrete->offsetExists($offset);
    }

    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset) == false) {
            $exception  = new LogicException('Undefined offset!');
            $exception->setComponentName('datatypes');

            throw $exception;
        }

        $character = $this->concrete->substr($offset, 1);

        return new self($character->__toString());
    }

    public function offsetSet($offset, $value): void
    {
        $this->concrete->offsetSet($offset, $value);

        self::__construct($this->concrete->__toString());
    }

    public function offsetUnset($offset): void
    {
        $this->concrete->offsetUnset($offset);

        self::__construct($this->concrete->__toString());
    }
}
