<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Core\Contracts;

interface VoidInterface extends PseudoInterface
{
    public function isVoid(): BooleanInterface;

    public function __toVoid(): void;
}
