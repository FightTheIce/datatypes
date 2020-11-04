<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Compounds;

use Closure;
use FightTheIce\Datatypes\Core\Contracts\Datatype;
use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\Support\Traits\Macroable;
use ReflectionClass;
use ReflectionFunction;

class Object_ implements Datatype
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
            throw new \ErrorException('Must be an object');
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
     * __call.
     *
     * @param string $method
     * @param mixed  $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (method_exists($this->object, $method)) {
            return $this->forwardCallTo($this->object, $method, $parameters);
        }

        return $this->__parentcall($method, $parameters);
    }
}
