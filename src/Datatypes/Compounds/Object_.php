<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Compounds;

use Closure;
use FightTheIce\Datatypes\Core\Contracts\DatatypeInterface;
use FightTheIce\Datatypes\Core\Contracts\ResolvableInterface;
use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\Support\Traits\Macroable;
use ReflectionClass;
use ReflectionFunction;
use FightTheIce\Exceptions\InvalidArgumentException;
use FightTheIce\Datatypes\Scalar\String_;
use FightTheIce\Datatypes\Scalar\Integer_;

class Object_ implements DatatypeInterface, ResolvableInterface
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

    /**
     * __construct.
     *
     * @param mixed $obj
     */
    public function __construct($obj)
    {
        if (!is_object($obj)) {
            $exception = new InvalidArgumentException('Parameter $obj must be an object');
            $exception->setComponentName('datatypes');

            throw $exception;
        }

        $this->object = $obj;
    }

    /**
     * getValue.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->object;
    }

    /**
     * @return ReflectionClass|ReflectionFunction
     *

     */
    public function getReflection()
    {
        if ($this->object instanceof Closure) {
            return new ReflectionFunction($this->object);
        }

        return new ReflectionClass($this->object);
    }

    /**
     * resolve.
     *
     * @return mixed
     */
    public function resolve()
    {
        return $this->object;
    }

    public function getHash(): String_
    {
        return new String_(spl_object_hash($this->resolve()));
    }

    public function getId(): Integer_
    {
        return new Integer_(spl_object_id($this->resolve()));
    }
}
