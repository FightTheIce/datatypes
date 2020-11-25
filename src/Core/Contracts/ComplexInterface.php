<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Core\Contracts;

interface ComplexInterface extends DatatypeInterface
{
    public function getPrimitiveType(): string;
}
