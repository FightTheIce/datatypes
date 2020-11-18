<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Compound;

use FightTheIce\Datatypes\Core\Contracts\IterableInterface;
use Illuminate\Support\Traits\Macroable;
use Thunder\Nevar\Nevar;

class Iterable_ implements IterableInterface
{
    use Macroable;

    /**
     * iterate.
     *
     * @var iterable
     */
    protected $iterate;

    public function __construct(iterable $it = [])
    {
        $this->iterate = $it;
    }

    public function __toIterable()
    {
        return $this->iterate;
    }

    public function getPrimitiveType(): string
    {
        return 'iterable';
    }

    public function getDatatypeCategory(): string
    {
        return 'compound';
    }

    public function describe(): string
    {
        return Nevar::describe($this->iterate);
    }
}
