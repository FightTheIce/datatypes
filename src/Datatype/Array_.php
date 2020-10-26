<?php
declare (strict_types = 1);

namespace FightTheIce\Datatypes\Datatype;
use ArrayAccess;
use FightTheIce\Datatypes\Core\Interfaces\DatatypeInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\Support\Traits\Macroable;

class Array_ implements DatatypeInterface, ArrayAccess {
    use ForwardsCalls;
    use Macroable {
        __call as __parentcall;
    }
    /**
     * value
     * @var array
     */
    protected $value = array();

    /**
     * collection
     * @var Collection
     */
    protected $collection;

    /**
     * __construct
     * Class construct
     * @param array $value An array of values
     */
    public function __construct(array $value = []) {
        $this->value = new Collection($this->value);
    }

    /**
     * getType
     * @return string
     */
    public function getType(): string {
        return 'array';
    }

    /**
     * getValue
     * @return array
     */
    public function getValue(): array{
        return $this->value->toArray();
    }

    public function offsetExists($offset): bool {
        return isset($this->value[$offset]);
    }

    public function offsetGet($offset) {
        return isset($this->value[$offset]) ? $this->value[$offset] : null;
    }

    public function offsetSet($offset, $value): void {
        if (is_null($offset)) {
            $this->value[] = $value;
        } else {
            $this->value[$offset] = $value;
        }

        $this->collection = new Collection($this->value);
    }

    public function offsetUnset($offset) {
        unset($this->value[$offset]);
    }

    public function __call(string $name, array $arguments) {
        if (method_exists($this->collection, $name)) {
            $this->value = $this->forwardCallTo($this->collection, $name, $arguments);

            return $this;
        }

        return $this->parent__call($name, $arguments);
    }

    /**
     * reindex
     * Reindex the numeric keys of the array starting at position 0
     *
     * @return self
     */
    public function reindex(): self{
        $counter  = 0;
        $newArray = array();
        foreach ($this->value as $key => $value) {
            if (is_string($key)) {
                $newArray[$key] = $value;
            } else {
                $newArray[$counter] = $value;
                $counter++;
            }
        }

        self::__construct($newArray);

        return $this;
    }

    /**
     * Add an element to an array using "dot" notation if it doesn't exist.
     *
     * @param  array  $array
     * @param  string  $key
     * @param  mixed  $value
     * @return array
     */
    public function add($key, $value) {
        $arr      = new Arr();
        $newValue = $arr->add($this->value, $key, $value);

        $this->value = new Collection($newValue);

        return $this;
    }
}
