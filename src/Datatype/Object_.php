<?php
declare (strict_types = 1);

namespace FightTheIce\Datatypes\Datatype;
use FightTheIce\Datatypes\Core\Interfaces\DatatypeInterface;
use Illuminate\Support\Traits\Macroable;
use ReflectionClass;
use ReflectionFunction;
use Reflector;

class Object_ implements DatatypeInterface {
    use Macroable;

    protected $value;

    public function __construct($obj) {
        if (!is_object($obj)) {
            throw new \ErrorException('must be an object');
        }

        $this->value = $obj;
    }

    public function getReflection(): Reflector {
        switch (get_class($this->value)) {
        case 'Closure':
            return new ReflectionFunction($this->value);
            break;

        default:
            return new ReflectionClass($this->value);
            break;
        }
    }

    public function getType(): string {
        return 'object';
    }

    public function getValue() {
        return $this->value;
    }

    public function refresh($obj): self{
        self::__construct($obj);

        return $this;
    }
}