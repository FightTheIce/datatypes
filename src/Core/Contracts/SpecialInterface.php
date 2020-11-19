<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Core\Contracts;

interface SpecialInterface extends DatatypeInterface
{
    public function getPrimitiveType(): string;
}
