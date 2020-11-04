<?php
declare (strict_types = 1);

namespace FightTheIce\Datatypes\Compounds;

use Closure;
use FightTheIce\Datatypes\Core\Datatype;
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

    protected $object;

    function __construct($obj)
    {
        if (!is_object($obj)) {
            throw new \ErrorException('Must be an object');
        }

        $this->object = $obj;
    }

    function getValue()
    {
        return $this->object;
    }

    /**
     * @return ReflectionClass|ReflectionFunction
     *
     * @psalm-return ReflectionClass<mixed>|ReflectionFunction
     */
    function getReflection()
    {
        if ($this->object instanceof Closure) {
            return new ReflectionFunction($this->object);
        }

        return new ReflectionClass($this->object);
    }

    function __call($method, $parameters)
    {
        if (method_exists($this->class, $method)) {
            return $this->forwardCallTo($this->class, $method, $parameters);
        }

        return $this->__parentcall($method, $parameters);
    }
}
