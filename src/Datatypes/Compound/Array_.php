<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Compound;

use FightTheIce\Datatypes\Core\Contracts\ArrayInterface;
use Thunder\Nevar\Nevar;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use FightTheIce\Datatypes\Core\Contracts\BooleanInterface;
use FightTheIce\Datatypes\Scalar\Boolean_;
use Spatie\CollectionMacros\Macros\After;
use Spatie\CollectionMacros\Macros\At;
use Spatie\CollectionMacros\Macros\Before;
use Spatie\CollectionMacros\Macros\ChunkBy;
use Spatie\CollectionMacros\Macros\CollectBy;
use Spatie\CollectionMacros\Macros\EachCons;
use Spatie\CollectionMacros\Macros\Eighth;
use Spatie\CollectionMacros\Macros\Extract;
use Spatie\CollectionMacros\Macros\Fifth;
use Spatie\CollectionMacros\Macros\FilterMap;
use Spatie\CollectionMacros\Macros\FirstOrFail;
use Spatie\CollectionMacros\Macros\Fourth;
use Spatie\CollectionMacros\Macros\FromPairs;
use Spatie\CollectionMacros\Macros\Glob;
use Spatie\CollectionMacros\Macros\GroupByModel;
use Spatie\CollectionMacros\Macros\Head;
use Spatie\CollectionMacros\Macros\IfAny;
use Spatie\CollectionMacros\Macros\IfEmpty;
use Spatie\CollectionMacros\Macros\Ninth;
use Spatie\CollectionMacros\Macros\None;
use Spatie\CollectionMacros\Macros\Paginate;
use Spatie\CollectionMacros\Macros\ParallelMap;
use Spatie\CollectionMacros\Macros\PluckToArray;
use Spatie\CollectionMacros\Macros\Prioritize;
use Spatie\CollectionMacros\Macros\Rotate;
use Spatie\CollectionMacros\Macros\Second;
use Spatie\CollectionMacros\Macros\SectionBy;
use Spatie\CollectionMacros\Macros\Seventh;
use Spatie\CollectionMacros\Macros\SimplePaginate;
use Spatie\CollectionMacros\Macros\Sixth;
use Spatie\CollectionMacros\Macros\SliceBefore;
use Spatie\CollectionMacros\Macros\Tail;
use Spatie\CollectionMacros\Macros\Tenth;
use Spatie\CollectionMacros\Macros\Third;
use Spatie\CollectionMacros\Macros\ToPairs;
use Spatie\CollectionMacros\Macros\Transpose;
use Spatie\CollectionMacros\Macros\TryCatch;
use Spatie\CollectionMacros\Macros\Validate;
use Spatie\CollectionMacros\Macros\WithSize;
use Symfony\Component\Yaml\Yaml;
use Nette\Neon\Neon;
use FightTheIce\Exceptions\UnexpectedValueException;

class Array_ extends Collection implements ArrayInterface
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
            'after'          => After::class,
            'at'             => At::class,
            'before'         => Before::class,
            'chunkBy'        => ChunkBy::class,
            'collectBy'      => CollectBy::class,
            'eachCons'       => EachCons::class,
            'eighth'         => Eighth::class,
            'extract'        => Extract::class,
            'fifth'          => Fifth::class,
            'filterMap'      => FilterMap::class,
            'firstOrFail'    => FirstOrFail::class,
            'fourth'         => Fourth::class,
            'fromPairs'      => FromPairs::class,
            'glob'           => Glob::class,
            'groupByModel'   => GroupByModel::class,
            'head'           => Head::class,
            'ifAny'          => IfAny::class,
            'ifEmpty'        => IfEmpty::class,
            'ninth'          => Ninth::class,
            'none'           => None::class,
            'paginate'       => Paginate::class,
            'parallelMap'    => ParallelMap::class,
            'pluckToArray'   => PluckToArray::class,
            'prioritize'     => Prioritize::class,
            'rotate'         => Rotate::class,
            'second'         => Second::class,
            'sectionBy'      => SectionBy::class,
            'seventh'        => Seventh::class,
            'simplePaginate' => SimplePaginate::class,
            'sixth'          => Sixth::class,
            'sliceBefore'    => SliceBefore::class,
            'tail'           => Tail::class,
            'tenth'          => Tenth::class,
            'third'          => Third::class,
            'toPairs'        => ToPairs::class,
            'transpose'      => Transpose::class,
            'try'            => TryCatch::class,
            'validate'       => Validate::class,
            'withSize'       => WithSize::class,
        ];

        foreach ($macros as $name => $class) {
            $class = new $class();
            $this->macro($name, $class->__invoke());
        }
    }

    public function getPrimitiveType(): string
    {
        return 'array';
    }

    public function getDatatypeCategory(): string
    {
        return 'compound';
    }

    public function describe(): string
    {
        return Nevar::describe($this->items);
    }

    public function __toArray(): array
    {
        return $this->items;
    }

    /**
     * Add an element to an array using "dot" notation if it doesn't exist.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return ArrayInterface
     */
    public function addDot(string $key, $value): ArrayInterface
    {
        if ($this->hasDot($key)->isTrue() == true) {
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
     * @return ArrayInterface
     */
    public function removeDot(string $key): ArrayInterface
    {
        $currentValue = $this->toArray();

        if ($this->hasDot($key)->isTrue() == true) {
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
        if ($this->hasDot($key)->isTrue() == false) {
            $currentValue = $this->setDot($key, $default);
        }

        return (new Arr())->get($this, $key, $default);
    }

    /**
     * Determines if an array is associative.
     *
     * An array is "associative" if it doesn't have sequential numerical keys beginning with zero.
     *
     * @return BooleanInterface
     */
    public function isAssoc(): BooleanInterface
    {
        $currentValue = $this->toArray();

        return new Boolean_((new Arr())->isAssoc($currentValue));
    }

    /**
     * Set an array item to a given value using "dot" notation.
     *
     * If no key is given to the method, the entire array will be replaced.
     *
     * @param string|null $key
     * @param mixed       $value
     *
     * @return ArrayInterface
     */
    public function setDot($key, $value): ArrayInterface
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
     * @return BooleanInterface
     */
    public function hasDot(string $key): BooleanInterface
    {
        return new Boolean_((new Arr())->has($this->toArray(), $key));
    }

    public function __toJson(): string
    {
        $value = json_encode($this->items, JSON_PRETTY_PRINT);
        if ($value === false) {
            throw new UnexpectedValueException('Unexpected Value');
        }

        return $value;
    }

    public function __toYaml(): string
    {
        return Yaml::dump($this->items);
    }

    public function __toNeon(): string
    {
        return Neon::encode($this->items, Neon::BLOCK);
    }
}
