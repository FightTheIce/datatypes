<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Core\Contracts;

interface ScalarInterface extends DatatypeInterface
{
    public function getPrimitiveType(): string;
}
