<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Core\Contracts;

interface NumberStringInterface extends StringInterface
{
    public function is_string_float(): BooleanInterface;

    public function is_string_integer(): BooleanInterface;
}
