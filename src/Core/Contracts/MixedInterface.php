<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Core\Contracts;

interface MixedInterface extends PseudoInterface
{
    /**
     * __toMixed.
     *
     * @return mixed
     */
    public function __toMixed();

    //public function isCallable(): BooleanInterface;

    //public function isArray(): BooleanInterface;

    //public function isIterable(): BooleanInterface;

    //public function isObject(): BooleanInterface;

    //public function isBoolean(): BooleanInterface;

    //public function isInteger(): BooleanInterface;

    //public function isFloat(): BooleanInterface;
}
