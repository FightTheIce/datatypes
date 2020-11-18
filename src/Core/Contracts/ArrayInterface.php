<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Core\Contracts;

interface ArrayInterface extends CompoundInterface
{
    public function __toArray(): array;

    //public function __toJson(): string;

    //public function __toYaml(): string;

    //public function __toNeon(): string;
}
