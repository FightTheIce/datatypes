<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Compounds;

use FightTheIce\Datatypes\Core\Contracts\DatatypeInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Macroable;
use Symfony\Component\Yaml\Yaml;
use Nette\Neon\Neon;

class Array_ extends Collection implements DatatypeInterface
{
    use Macroable;

    /**
     * The items contained in the collection.
     *
     * @var array
     */
    protected $items = [];

    /**
     * Create a new collection.
     *
     * @param mixed $items
     */
    public function __construct($items = [])
    {
        $this->items = $this->getArrayableItems($items);

        $macros = [
            'after'          => \Spatie\CollectionMacros\Macros\After::class,
            'at'             => \Spatie\CollectionMacros\Macros\At::class,
            'before'         => \Spatie\CollectionMacros\Macros\Before::class,
            'chunkBy'        => \Spatie\CollectionMacros\Macros\ChunkBy::class,
            'collectBy'      => \Spatie\CollectionMacros\Macros\CollectBy::class,
            'eachCons'       => \Spatie\CollectionMacros\Macros\EachCons::class,
            'eighth'         => \Spatie\CollectionMacros\Macros\Eighth::class,
            'extract'        => \Spatie\CollectionMacros\Macros\Extract::class,
            'fifth'          => \Spatie\CollectionMacros\Macros\Fifth::class,
            'filterMap'      => \Spatie\CollectionMacros\Macros\FilterMap::class,
            'firstOrFail'    => \Spatie\CollectionMacros\Macros\FirstOrFail::class,
            'fourth'         => \Spatie\CollectionMacros\Macros\Fourth::class,
            'fromPairs'      => \Spatie\CollectionMacros\Macros\FromPairs::class,
            'glob'           => \Spatie\CollectionMacros\Macros\Glob::class,
            'groupByModel'   => \Spatie\CollectionMacros\Macros\GroupByModel::class,
            'head'           => \Spatie\CollectionMacros\Macros\Head::class,
            'ifAny'          => \Spatie\CollectionMacros\Macros\IfAny::class,
            'ifEmpty'        => \Spatie\CollectionMacros\Macros\IfEmpty::class,
            'ninth'          => \Spatie\CollectionMacros\Macros\Ninth::class,
            'none'           => \Spatie\CollectionMacros\Macros\None::class,
            'paginate'       => \Spatie\CollectionMacros\Macros\Paginate::class,
            'parallelMap'    => \Spatie\CollectionMacros\Macros\ParallelMap::class,
            'pluckToArray'   => \Spatie\CollectionMacros\Macros\PluckToArray::class,
            'prioritize'     => \Spatie\CollectionMacros\Macros\Prioritize::class,
            'rotate'         => \Spatie\CollectionMacros\Macros\Rotate::class,
            'second'         => \Spatie\CollectionMacros\Macros\Second::class,
            'sectionBy'      => \Spatie\CollectionMacros\Macros\SectionBy::class,
            'seventh'        => \Spatie\CollectionMacros\Macros\Seventh::class,
            'simplePaginate' => \Spatie\CollectionMacros\Macros\SimplePaginate::class,
            'sixth'          => \Spatie\CollectionMacros\Macros\Sixth::class,
            'sliceBefore'    => \Spatie\CollectionMacros\Macros\SliceBefore::class,
            'tail'           => \Spatie\CollectionMacros\Macros\Tail::class,
            'tenth'          => \Spatie\CollectionMacros\Macros\Tenth::class,
            'third'          => \Spatie\CollectionMacros\Macros\Third::class,
            'toPairs'        => \Spatie\CollectionMacros\Macros\ToPairs::class,
            'transpose'      => \Spatie\CollectionMacros\Macros\Transpose::class,
            'try'            => \Spatie\CollectionMacros\Macros\TryCatch::class,
            'validate'       => \Spatie\CollectionMacros\Macros\Validate::class,
            'withSize'       => \Spatie\CollectionMacros\Macros\WithSize::class,
        ];

        foreach ($macros as $name => $class) {
            $class = new $class();
            $this->macro($name, $class->__invoke());
            parent::macro($name, $class->__invoke());
        }

        parent::__construct($items);
    }

    /**
     * @return array
     */
    public function getValue()
    {
        return $this->toArray();
    }

    /**
     * Add an element to an array using "dot" notation if it doesn't exist.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return self
     */
    public function addDot(string $key, $value): Array_
    {
        if ($this->hasDot($key) == true) {
            return $this->setDot($key, $value);
        }

        $newValue = (new Arr())->add($this->toArray(), $key, $value);

        return new self($newValue);
    }

    /**
     * Remove one item from a given array using "dot" notation.
     *
     * @param string $key
     *
     * @return self
     */
    public function removeDot(string $key): Array_
    {
        $currentValue = $this->toArray();

        if ($this->hasDot($key) == true) {
            (new Arr())->forget($currentValue, $key);
        }

        return new self($currentValue);
    }

    /**
     * Get an item from an array using "dot" notation.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function getDot(string $key, $default = null)
    {
        $currentValue = $this->toArray();

        if ($this->hasDot($key) == false) {
            $currentValue = $this->setDot($key, $default);
        }

        return (new Arr())->get($currentValue, $key, $default);
    }

    /**
     * Determines if an array is associative.
     *
     * An array is "associative" if it doesn't have sequential numerical keys beginning with zero.
     *
     * @return bool
     */
    public function isAssoc(): bool
    {
        $currentValue = $this->toArray();

        return (new Arr())->isAssoc($currentValue);
    }

    /**
     * Set an array item to a given value using "dot" notation.
     *
     * If no key is given to the method, the entire array will be replaced.
     *
     * @param string|null $key
     * @param mixed       $value
     *
     * @return self
     */
    public function setDot($key, $value): Array_
    {
        $currentValue = $this->toArray();
        (new Arr())->set($currentValue, $key, $value);

        return new Array_($currentValue);
    }

    /**
     * Check if an item exist in an array using "dot" notation.
     *
     * @param string $key
     *
     * @return bool
     */
    public function hasDot(string $key): bool
    {
        return (new Arr())->has($this->toArray(), $key);
    }

    public function _toJson(): string
    {
        $data = json_encode($this->toArray(), JSON_PRETTY_PRINT);
        if ($data == false) {
            throw new \ErrorException(__METHOD__);
        }

        return $data;
    }

    public function _toYaml(): string
    {
        return Yaml::dump($this->toArray(), 3);
    }

    public function _toNeon(): string
    {
        return Neon::encode($this->toArray(), Neon::BLOCK);
    }
}
