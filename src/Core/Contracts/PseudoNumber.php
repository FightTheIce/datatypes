<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Core\Contracts;

interface PseudoNumberInterface extends PseudoInterface
{
    public function is_float(): BooleanInterface;

    public function is_integer(): BooleanInterface;

    public function resolve(): NumberInterface;
}
