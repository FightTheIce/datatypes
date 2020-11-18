<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Core\Contracts;

interface IterableInterface extends CompoundInterface
{
    /**
     * __toIterable.
     *
     * @return iterable
     */
    public function __toIterable();
}
