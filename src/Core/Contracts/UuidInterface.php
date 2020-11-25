<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Core\Contracts;

use Ramsey\Uuid\UuidInterface as RUuidInterface;

interface UuidInterface extends ComplexInterface
{
    public function __toUuid(): string;

    public function getIntegerString(): StringInterface;

    public function getUuidObj(): RUuidInterface;
}
