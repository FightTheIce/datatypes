<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Core\Contracts;

use Closure;

interface ClosureInterface extends ComplexInterface
{
    public function __construct(Closure $exec);

    public function __toClosure(): Closure;
}
