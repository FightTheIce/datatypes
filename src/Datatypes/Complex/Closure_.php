<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Complex;

use FightTheIce\Datatypes\Core\Contracts\ClosureInterface;
use Illuminate\Support\Traits\Macroable;
use Closure;

class Closure_ implements ClosureInterface
{
    use Macroable;

    /**
     * closure.
     *
     * @var Closure
     */
    protected Closure $closure;

    public function __construct(? Closure $exec = null)
    {
        if (is_null($exec)) {
            $exec = function (): void {};
        }

        $this->closure = $exec;
    }

    public function __toClosure(): Closure
    {
        return $this->closure;
    }

    public function getPrimitiveType(): string
    {
        return 'closure';
    }

    public function getDatatypeCategory(): string
    {
        return 'complex';
    }

    public function describe(): string
    {
        return 'closure';
    }
}
