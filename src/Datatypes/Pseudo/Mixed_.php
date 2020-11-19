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
use FightTheIce\Datatypes\Pseudo\String_ as PseudoString;
use FightTheIce\Datatypes\Core\Contracts\StringInterface;
use FightTheIce\Datatypes\Core\Contracts\ScalarInterface;
use FightTheIce\Datatypes\Core\Contracts\NumberInterface;
use FightTheIce\Datatypes\Core\Contracts\CompoundInterface;
use Closure;
use FightTheIce\Datatypes\Core\Contracts\SpecialInterface;
use FightTheIce\Datatypes\Core\Contracts\BooleanInterface;
use FightTheIce\Datatypes\Scalar\Integer_;
use FightTheIce\Datatypes\Scalar\Float_;
use FightTheIce\Datatypes\Scalar\UnicodeString_;
use FightTheIce\Datatypes\Scalar\String_;
use Thunder\Nevar\Nevar;

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
                if ($mixed instanceof Null_) {
                    $mixed = null;
                } elseif ($mixed instanceof Resource_) {
                    $mixed = $mixed->__toResource();
                } elseif ($mixed instanceof StringInterface) {
                    $mixed = $mixed->__toString();
                } elseif ($mixed instanceof NumberInterface) {
                    $mixed = $mixed->getNumber();
                } elseif ($mixed instanceof Boolean_) {
                    $mixed = $mixed->__toBoolean();
                } elseif ($mixed instanceof Mixed_) {
                    $mixed = $mixed->__toMixed();
                } elseif ($mixed instanceof Object_) {
                    $mixed = $mixed->__toObject();
                } elseif ($mixed instanceof Iterable_) {
                    $mixed = $mixed->__toIterable();
                } elseif ($mixed instanceof Callable_) {
                    $mixed = $mixed->__toCallable();
                } elseif ($mixed instanceof Array_) {
                    $mixed = $mixed->__toArray();
                }
            }
        }

        $this->mixed = $mixed;

        if ($mixed instanceof Void_) {
            $this->concrete = new Void_();
        } elseif ((is_object($mixed)) && (!is_iterable($mixed))) {
            $this->concrete = new Object_($mixed);
        } elseif (is_callable($mixed)) {
            $this->concrete = new Callable_($mixed);
        } elseif (is_array($mixed)) {
            $this->concrete = new Array_($mixed);
        } elseif (is_iterable($mixed)) {
            $this->concrete = new Iterable_($mixed);
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
            $this->concrete = new Null_();
        }
    }

    public function __toMixed()
    {
        return $this->mixed;
    }

    public function getPrimitiveType(): string
    {
        return 'mixed';
    }

    public function getDatatypeCategory(): string
    {
        return 'pseudo';
    }

    public function describe(): string
    {
        $describe = Nevar::describe($this->mixed);
        if ($describe == 'unknown type') {
            $describe = $this->concrete->describe();
        }

        return $describe;
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

    public function isSpecialType(): BooleanInterface
    {
        return new Boolean_(($this->concrete instanceof SpecialInterface));
    }

    public function resolve()
    {
        return $this->concrete;
    }

    public function isVoid(): BooleanInterface
    {
        return new Boolean_(($this->concrete instanceof Void_));
    }
}
