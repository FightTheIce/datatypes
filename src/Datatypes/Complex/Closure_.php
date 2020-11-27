<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Complex;

use FightTheIce\Datatypes\Core\Contracts\ClosureInterface;
use Illuminate\Support\Traits\Macroable;
use Closure;
use Dont\DontGet;
use Dont\DontSet;
use FightTheIce\Datatypes\Core\Traits\PreventConstructorFromRunningTwice;

class Closure_ implements ClosureInterface
{
    use Macroable;
    use DontGet;
    use DontSet;
    use PreventConstructorFromRunningTwice;

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

        $this->hasConstructorRun();
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
