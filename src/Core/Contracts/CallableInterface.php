<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Core\Contracts;

interface CallableInterface extends CompoundInterface
{
    /**
     * resolveCallable.
     *
     * @param mixed $args
     *
     * @return mixed
     */
    public function resolveCallable(...$args);

    /**
     * __toCallable.
     *
     * @return mixed
     */
    public function __toCallable();

    public function is_callable_string(): BooleanInterface;

    public function is_callable_array(): BooleanInterface;

    public function is_callable_closure(): BooleanInterface;
}
