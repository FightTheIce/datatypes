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
use FightTheIce\Datatypes\Pseudo\String_ as PseudoString_;
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
     */
    public function __construct($mixed = '')
    {
        $this->mixed    = $mixed;
        $this->concrete = new Null_();

        $describe = Nevar::describe($mixed);

        //echo $describe.PHP_EOL;
        switch ($describe) {
            case 'empty array':
            case 'indexed array':
            case 'associative array':
                //echo 'Array_'.PHP_EOL;
                $this->concrete = new Array_($mixed);
            break;

            case 'callable string':
            case 'callable array':
            case 'object of class Closure':
                //echo 'Callable_'.PHP_EOL;
                $this->concrete = new Callable_($mixed);
            break;

            case substr($describe, 0, 15) == 'object of class':
                if (is_iterable($mixed)) {
                    //echo 'Iterable_'.PHP_EOL;
                    $this->concrete = new Iterable_($mixed);
                } else {
                    if ($describe == 'object of class FightTheIce\Datatypes\Pseudo\Void_') {
                        //echo 'Void_'.PHP_EOL;
                        $this->concrete = new Void_();
                    } else {
                        //echo 'Object_'.PHP_EOL;
                        $this->concrete = new Object_($mixed);
                    }
                }
            break;

            case 'positive integer':
            case 'numeric string':
            case 'positive float':
            case 'negative integer':
            case 'negative float':
                //echo 'Number_'.PHP_EOL;
                $mixing         = new Number_($mixed);
                $this->concrete = $mixing->resolve();
            break;

            case 'empty string':
            case 'string':
                //echo 'String_'.PHP_EOL;
                $mixing         = new PseudoString_($mixed);
                $this->concrete = $mixing->resolve();
            break;

            case 'unknown type':
                if (is_null($mixed)) {
                    //echo 'Null_'.PHP_EOL;
                    $this->concrete = new Null_($mixed);
                }
            break;

            case 'boolean false':
            case 'boolean true':
                //echo 'Boolean_'.PHP_EOL;
                $this->concrete = new Boolean_($mixed);
            break;

            case substr($describe, 0, 8) == 'resource':
                //echo 'Resource_'.PHP_EOL;
                $this->concrete = new Resource_($mixed);
            break;

            default:
                throw new \ErrorException(__METHOD__);
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
