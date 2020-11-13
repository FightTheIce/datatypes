<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Pseudo;

use FightTheIce\Datatypes\Compounds\Array_;
use FightTheIce\Datatypes\Compounds\Object_;
use FightTheIce\Datatypes\Core\Contracts\DatatypeInterface;
use FightTheIce\Datatypes\Core\Contracts\ResolvableInterface;
use FightTheIce\Datatypes\Scalar\Boolean_;
use FightTheIce\Datatypes\Scalar\Float_;
use FightTheIce\Datatypes\Scalar\Integer_;
use FightTheIce\Datatypes\Scalar\String_;
use FightTheIce\Datatypes\Scalar\UnicodeString_;
use FightTheIce\Datatypes\Special\Null_;
use FightTheIce\Datatypes\Special\Resource_;
use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\Support\Traits\Macroable;
use Closure;
use Thunder\Nevar\Nevar;

class Mixed_ implements DatatypeInterface, ResolvableInterface
{
    use Macroable {
        __call as __parentcall;
    }

    use ForwardsCalls;

    /**
     * object.
     *
     * @var mixed
     */
    protected $object;

    protected DatatypeInterface $class;
    protected string $gettype;
    private bool $determined = false;

    /**
     * __construct.
     *
     * @param mixed $obj
     */
    public function __construct($obj)
    {
        if ($obj instanceof DatatypeInterface) {
            $obj = $obj->getValue();
        }

        $this->object  = $obj;
        $this->gettype = strtolower(gettype($this->object));

        if (is_array($obj)) {
            $this->class      = new Array_($obj);
            $this->determined = true;
        }

        if (($this->determined == false) and (is_string($obj))) {
            //https://stackoverflow.com/questions/1350758/check-unicode-in-php
            //we need to determine unicode or not
            if (strlen($obj) != strlen(utf8_decode($obj))) {
                //unicode
                $this->class = new UnicodeString_($obj);
            } else {
                //no unicode
                $this->class = new String_($obj);
            }
            $this->determined = true;
        }

        if (($this->determined == false) and (is_bool($obj))) {
            $this->class      = new Boolean_($obj);
            $this->determined = true;
        }

        if (($this->determined == false) and (is_float($obj))) {
            $this->class      = new Float_($obj);
            $this->determined = true;
            $this->gettype    = 'float';
        }

        if (($this->determined == false) and (is_int($obj))) {
            $this->class      = new Integer_($obj);
            $this->determined = true;
        }

        if (($this->determined == false) and (is_object($obj))) {
            if ($obj instanceof Closure) {
                //this is a closure
                $this->gettype = 'closure';
            }

            $this->class      = new Object_($obj);
            $this->determined = true;
        }

        if (($this->determined == false) and (is_null($obj))) {
            $this->class      = new Null_();
            $this->determined = true;
        }

        if (($this->determined == false) and (is_resource($obj))) {
            $this->class      = new Resource_($obj);
            $this->determined = true;
        }

        if ($this->determined == false) {
            throw new \ErrorException('Unable to determine object type');
        }
    }

    public function is_null(): bool
    {
        return is_null($this->object);
    }

    public function is_empty(): bool
    {
        return empty($this->object);
    }

    public function is_string(): bool
    {
        return is_string($this->object);
    }

    public function is_unicode_string(): bool
    {
        if ($this->is_string() == false) {
            return false;
        }

        if (strlen($this->object) != strlen(utf8_decode($this->object))) {
            return true;
        }

        return false;
    }

    public function is_scalar(): bool
    {
        return is_scalar($this->object);
    }

    public function is_float(): bool
    {
        return is_float($this->object);
    }

    public function is_int(): bool
    {
        return is_int($this->object);
    }

    public function is_bool(): bool
    {
        return is_bool($this->object);
    }

    public function is_object(): bool
    {
        return is_object($this->object);
    }

    public function is_array(): bool
    {
        return is_array($this->object);
    }

    public function is_numeric(): bool
    {
        return is_numeric($this->object);
    }

    public function is_closure(): bool
    {
        if ($this->is_object() == false) {
            return false;
        }

        return $this->object instanceof Closure;
    }

    public function getValue()
    {
        return $this->object;
    }

    public function getDatatypeClass(): DatatypeInterface
    {
        return $this->class;
    }

    public function getType(): string
    {
        return $this->gettype;
    }

    /**
     * resolve.
     *
     * @return mixed
     */
    public function resolve()
    {
        return $this->class;
    }

    /**
     * getObject
     * Returns the mixed object.
     *
     * @return mixed
     */
    public function getObject()
    {
        return $this->getValue();
    }

    public function describe(): string
    {
        return Nevar::describe($this->object);
    }
}
