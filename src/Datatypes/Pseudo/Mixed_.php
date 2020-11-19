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
use FightTheIce\Datatypes\Special\Null_;
use FightTheIce\Datatypes\Special\Resource_;
use FightTheIce\Exceptions\InvalidArgumentException;
use FightTheIce\Datatypes\Pseudo\String_ as PseudoString;
use FightTheIce\Datatypes\Core\Contracts\StringInterface;
use FightTheIce\Datatypes\Core\Contracts\ScalarInterface;
use FightTheIce\Datatypes\Core\Contracts\NumberInterface;
use FightTheIce\Datatypes\Core\Contracts\CompoundInterface;
use Closure;
use FightTheIce\Datatypes\Core\Contracts\PseudoInterface;
use FightTheIce\Datatypes\Core\Contracts\SpecialInterface;
use FightTheIce\Datatypes\Core\Contracts\BooleanInterface;
use FightTheIce\Datatypes\Scalar\Integer_;
use FightTheIce\Datatypes\Scalar\Float_;
use FightTheIce\Datatypes\Scalar\UnicodeString_;

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
        } elseif ((is_float($mixed)) || (is_int($mixed))) {
            $mixing         = new Number_($mixed);
            $this->concrete = $mixing->resolve();
        } elseif (is_string($mixed)) {
            $mixing         = new PseudoString($mixed);
            $this->concrete = $mixing->resolve();
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

    public function isCallable(): BooleanInterface
    {
        return new Boolean_(($this->concrete instanceof Callable_));
    }

    public function isArray(): BooleanInterface
    {
        return new Boolean_(($this->concrete instanceof Array_));
    }

    public function isIterable(): BooleanInterface
    {
        return new Boolean_(($this->concrete instanceof Iterable_));
    }

    public function isObject(): BooleanInterface
    {
        return new Boolean_(($this->concrete instanceof Object_));
    }

    public function isBoolean(): BooleanInterface
    {
        return new Boolean_(($this->concrete instanceof Boolean_));
    }

    public function isInteger(): BooleanInterface
    {
        return new Boolean_(($this->concrete instanceof Integer_));
    }

    public function isFloat(): BooleanInterface
    {
        return new Boolean_(($this->concrete instanceof Float_));
    }

    public function isString(): BooleanInterface
    {
        return new Boolean_(($this->concrete instanceof StringInterface));
    }

    public function isNull(): BooleanInterface
    {
        return new Boolean_(($this->concrete instanceof Null_));
    }

    public function isResource(): BooleanInterface
    {
        return new Boolean_(($this->concrete instanceof Resource_));
    }

    public function isStandardString(): BooleanInterface
    {
        return new Boolean_(($this->concrete instanceof String_));
    }

    public function isUnicodeString(): BooleanInterface
    {
        return new Boolean_(($this->concrete instanceof UnicodeString_));
    }

    public function isEmpty(): BooleanInterface
    {
        return new Boolean_(empty($this->mixed));
    }

    public function isScalarType(): BooleanInterface
    {
        return new Boolean_(($this->concrete instanceof ScalarInterface));
    }

    public function isNumeric(): BooleanInterface
    {
        return new Boolean_(($this->concrete instanceof NumberInterface));
    }

    public function isClosure(): BooleanInterface
    {
        return new Boolean_(($this->mixed instanceof Closure));
    }

    public function isCompoundType(): BooleanInterface
    {
        return new Boolean_(($this->concrete instanceof CompoundInterface));
    }

    public function isPseudoType(): BooleanInterface
    {
        return new Boolean_(($this->concrete instanceof PseudoInterface));
    }

    public function isSpecialType(): BooleanInterface
    {
        return new Boolean_(($this->concrete instanceof SpecialInterface));
    }

    public function resolve()
    {
        return $this->concrete;
    }
}
