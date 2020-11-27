<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Compound;

use FightTheIce\Datatypes\Core\Contracts\IterableInterface;
use Illuminate\Support\Traits\Macroable;
use Thunder\Nevar\Nevar;
use Dont\DontGet;
use Dont\DontSet;
use FightTheIce\Datatypes\Core\Traits\PreventConstructorFromRunningTwice;

class Iterable_ implements IterableInterface
{
    use Macroable;
    use DontGet;
    use DontSet;
    use PreventConstructorFromRunningTwice;

    /**
     * iterate.
     *
     * @var iterable
     */
    protected $iterate;

    public function __construct(iterable $it = [])
    {
        $this->iterate = $it;

        $this->hasConstructorRun();
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
