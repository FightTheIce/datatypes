<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Compound;

use FightTheIce\Datatypes\Core\Contracts\ObjectInterface;
use Illuminate\Support\Traits\Macroable;
use Thunder\Nevar\Nevar;
use Reflector;
use ReflectionFunction;
use ReflectionClass;
use FightTheIce\Datatypes\Core\Contracts\StringInterface;
use FightTheIce\Datatypes\Scalar\String_;
use FightTheIce\Datatypes\Core\Contracts\IntegerInterface;
use FightTheIce\Datatypes\Scalar\Integer_;
use stdClass;
use FightTheIce\Exceptions\InvalidArgumentException;
use Closure;
use Dont\DontGet;
use Dont\DontSet;
use FightTheIce\Datatypes\Core\Traits\PreventConstructorFromRunningTwice;

class Object_ implements ObjectInterface
{
    use Macroable;
    use DontGet;
    use DontSet;
    use PreventConstructorFromRunningTwice;

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
    public function __construct($obj = null)
    {
        if (is_null($obj)) {
            $obj = new stdClass();
        }

        if (!is_object($obj)) {
            $exception = new InvalidArgumentException('Parameter $obj must be an object');
            $exception->setComponentName('datatypes');

            throw $exception;
        }

        $this->object = $obj;

        $this->hasConstructorRun();
    }

    /**
     * __toObject.
     *
     * @return mixed
     */
    public function __toObject()
    {
        return $this->object;
    }

    public function getPrimitiveType(): string
    {
        return 'object';
    }

    public function getDatatypeCategory(): string
    {
        return 'compound';
    }

    public function describe(): string
    {
        return Nevar::describe($this->object);
    }

    public function getReflection(): Reflector
    {
        if ($this->object instanceof Closure) {
            return new ReflectionFunction($this->object);
        }

        return new ReflectionClass($this->object);
    }

    public function getHash(): StringInterface
    {
        return new String_(spl_object_hash($this->object));
    }

    public function getId(): IntegerInterface
    {
        return new Integer_(spl_object_id($this->object));
    }
}
