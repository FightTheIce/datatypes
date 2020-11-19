<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Pseudo;

use FightTheIce\Datatypes\Core\Contracts\MixedInterface;
use Illuminate\Support\Traits\Macroable;
use FightTheIce\Datatypes\Core\Contracts\DatatypeInterface;
use FightTheIce\Datatypes\Compound\Array_;
use FightTheIce\Datatypes\Compound\Iterable_;
use FightTheIce\Datatypes\Compound\Callable_;
use FightTheIce\Datatypes\Compound\Object_;
use FightTheIce\Datatypes\Scalar\Boolean_;
use FightTheIce\Datatypes\Scalar\Integer_;
use FightTheIce\Datatypes\Scalar\Float_;
use FightTheIce\Datatypes\Scalar\String_;
use FightTheIce\Datatypes\Scalar\UnicodeString_;
use FightTheIce\Datatypes\Special\Null_;
use FightTheIce\Datatypes\Special\Resource_;
use FightTheIce\Exceptions\InvalidArgumentException;

class Mixed_ implements MixedInterface
{
    use Macroable;

    /**
     * mixed.
     *
     * @var DatatypeInterface
     */
    protected DatatypeInterface $concrete;

    /**
     * mixed.
     *
     * @var mixed
     */
    protected $mixed;

    /**
     * __construct.
     *
     * @param mixed $mixed
     * @param bool  $resolveInternal
     */
    public function __construct($mixed = '', bool $resolveInternal = false)
    {
        if ($mixed instanceof DatatypeInterface) {
            if ($resolveInternal === true) {
                //resolve here
            }
        }

        $this->mixed = $mixed;

        if (is_callable($mixed)) {
            $this->concrete = new Callable_($mixed);
        } elseif (is_array($mixed)) {
            $this->concrete = new Array_($mixed);
        } elseif (is_iterable($mixed)) {
            $this->concrete = new Iterable_($mixed);
        } elseif (is_object($mixed)) {
            $this->concrete = new Object_($mixed);
        } elseif (is_bool($mixed)) {
            $this->concrete = new Boolean_($mixed);
        } elseif (is_int($mixed)) {
            $this->concrete = new Integer_($mixed);
        } elseif (is_float($mixed)) {
            $this->concrete = new Float_($mixed);
        } elseif (is_string($mixed)) {
            if (strlen($mixed) != strlen(utf8_decode($mixed))) {
                //unicode
                $this->concrete = new UnicodeString_($mixed);
            } else {
                //no unicode
                $this->concrete = new String_($mixed);
            }
        } elseif (is_null($mixed)) {
            $this->concrete = new Null_($mixed);
        } elseif (is_resource($mixed)) {
            $this->concrete = new Resource_($mixed);
        } else {
            $exception = new InvalidArgumentException('Unable to determine data type');
            $exception->setComponentName('datatypes');

            throw $exception;
        }
    }

    public function __toMixed()
    {
        return $this->mixed;
    }

    public function getPrimitiveType(): string
    {
        return $this->concrete->getPrimitiveType();
    }

    public function getDatatypeCategory(): string
    {
        return $this->concrete->getDatatypeCategory();
    }

    public function describe(): string
    {
        return $this->concrete->describe();
    }
}
