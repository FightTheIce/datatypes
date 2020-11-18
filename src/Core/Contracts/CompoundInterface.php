<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Core\Contracts;

interface CompoundInterface extends DatatypeInterface
{
    public function getPrimitiveType(): string;
}
