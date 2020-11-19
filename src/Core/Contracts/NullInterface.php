<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Core\Contracts;

interface NullInterface extends SpecialInterface
{
    public function isNull(): BooleanInterface;

    /**
     * __toNull.
     *
     * @psalm-return null
     */
    public function __toNull();
}
