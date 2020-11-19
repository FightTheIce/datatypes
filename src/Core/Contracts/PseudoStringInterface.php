<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Core\Contracts;

interface PseudoStringInterface extends PseudoInterface
{
    public function __toString(): string;

    public function is_standard_string(): BooleanInterface;

    public function is_unicode_string(): BooleanInterface;

    public function resolve(): StringInterface;
}
