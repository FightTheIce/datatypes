<?php
declare (strict_types = 1);

namespace FightTheIce\Datatypes\Datatype;
use ArrayAccess;
use ArrayIterator;
use FightTheIce\Datatypes\Core\Interfaces\DatatypeInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\Support\Traits\Macroable;
use IteratorAggregate;

class Array_ implements DatatypeInterface, ArrayAccess, IteratorAggregate {
    use ForwardsCalls;
    use Macroable {
        __call as __parentcall;
    }

    /**
     * collection
     * @var \Illuminate\Support\Collection
     */
    protected $collection;

    /**
     * arr
     * @var \Illuminate\Support\Arr
     */
    protected $arr;

    public function __construct(array $arr = []) {
        $this->collection = new Collection($arr);
        $this->arr        = new Arr();
    }

    public function getType(): string {
        return 'array';
    }

    public function getValue(): array{
        return $this->collection->toArray();
    }

    public function offsetExists($offset): bool {
        return isset($this->collection[$offset]);
    }

    public function offsetGet($offset) {
        return isset($this->collection[$offset]) ? $this->collection[$offset] : null;
    }

    public function offsetSet($offset, $value): void {
        if (is_null($offset)) {
            $this->collection[] = $value;
        } else {
            $this->collection[$offset] = $value;
        }
    }

    public function offsetUnset($offset) {
        unset($this->collection[$offset]);
    }

    /**
     * Add an element to an array using "dot" notation if it doesn't exist.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return self
     */
    public function addDot(string $key, $value): self {
        if ($this->hasDot($key) == true) {
            $this->setDot($key, $value);
        } else {
            $newValue = $this->arr->add($this->collection->toArray(), $key, $value);

            $this->collection = new Collection($newValue);
        }

        return $this;
    }

    /**
     * Remove one item from a given array using "dot" notation.
     *
     * @param  string  $key
     * @return self
     */
    public function removeDot(string $key): self{
        $currentValue = $this->collection->toArray();
        $this->arr->forget($currentValue, $key);

        $this->collection = new Collection($currentValue);

        return $this;
    }

    /**
     * Divide an array into two arrays. One with keys and the other with values.
     *
     * @return self
     */
    public function divide() {
        $currentValue = $this->toArray();

        $newValue = $this->arr->divide($currentValue);

        $this->collection = new Collection($newValue);

        return $this;
    }

    /**
     * Flatten a multi-dimensional associative array with dots.
     *
     * @param  string  $prepend
     * @return self
     */
    public function dot($prepend = '') {
        $currentValue = $this->toArray();

        $newValue = $this->arr->dot($currentValue, $prepend);

        $this->collection = new Collection($newValue);

        return $this;
    }

    /**
     * Determine if the given key exists in the provided array.
     *
     * @param  string|int  $key
     * @return bool
     */
    public function exists($key) {
        $currentValue = $this->toArray();

        return $this->arr->exists($currentValue, $key);
    }

    /**
     * Get an item from an array using "dot" notation.
     *
     * @param  string|int|null  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function getDot($key, $default = null) {
        $currentValue = $this->toArray();

        return $this->arr->get($currentValue, $key, $default);
    }

    /**
     * Determine if any of the keys exist in an array using "dot" notation.
     *
     * @param  string|array  $keys
     * @return bool
     */
    public function hasAny(string $key) {
        $currentValue = $this->toArray();

        return $this->arr->hasAny($currentValue, $key);
    }

    /**
     * Determines if an array is associative.
     *
     * An array is "associative" if it doesn't have sequential numerical keys beginning with zero.
     *
     * @return bool
     */
    public function isAssoc() {
        $currentValue = $this->toArray();

        return $this->arr->isAssoc($currentValue);
    }

    /**
     * Set an array item to a given value using "dot" notation.
     *
     * If no key is given to the method, the entire array will be replaced.
     *
     * @param  string|null  $key
     * @param  mixed  $value
     * @return self
     */
    public function setDot($key, $value) {
        $currentValue = $this->toArray();
        $this->arr->set($currentValue, $key, $value);

        $this->collection = new Collection($currentValue);

        return $this;
    }

    /**
     * Recursively sort an array by keys and values.
     *
     * @param  int  $options
     * @param  bool  $descending
     * @return self
     */
    public function sortRecursive($options = SORT_REGULAR, $descending = false) {
        $currentValue = $this->toArray();

        $newValue = $this->arr->sortRecursive($currentValue, $options, $descending);

        $this->collection = new Collection($newValue);

        return $this;
    }

    /**
     * Convert the array into a query string.
     *
     * @param  array  $array
     * @return string
     */
    public function query() {
        $currentValue = $this->toArray();

        return $this->arr->query($currentValue);
    }

    /**
     * Filter the array using the given callback.
     *
     * @param  array  $array
     * @param  callable  $callback
     * @return self
     */
    public function where(callable $callback) {
        $currentValue = $this->toArray();

        $newValue = $this->arr->where($currentValue, $callback);

        $this->collection = new Collection($newValue);

        return $this;
    }

    /**
     * Check if an item exist in an array using "dot" notation.
     *
     * @param  string|array  $keys
     * @return bool
     */
    public function hasDot(string $key) {
        return $this->arr->has($this->toArray(), $key);
    }

    /**
     * Get an iterator for the items.
     *
     * @return \ArrayIterator
     */
    public function getIterator() {
        return new ArrayIterator($this->collection->toArray());
    }

    public function __call(string $name, array $arguments) {
        if (method_exists($this->collection, $name)) {
            $response = $this->forwardCallTo($this->collection, $name, $arguments);
            if ($response instanceof ArrayAccess) {
                $this->collection = new Collection($response);
                return $this;
            }

            return $response;
        }

        return $this->__parentcall($name, $arguments);
    }

    /**
     * refresh
     * Refresh the object with a new array
     *
     * @param  array  $arr
     * @return self
     */
    public function refresh(array $arr): self{
        self::__construct($arr);

        return $this;
    }

}
