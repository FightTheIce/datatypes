<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Core\Contracts;

interface DatatypeInterface
{
    public function getDatatypeCategory(): string;

    public function describe(): string;
}
