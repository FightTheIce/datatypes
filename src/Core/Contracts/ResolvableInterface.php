<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Core\Contracts;

interface ResolvableInterface
{
    /**
     * resolve
     *
     * @return mixed
     */
    public function resolve();
}
