<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Core\Contracts;

interface BooleanInterface extends ScalarInterface
{
    public function isFalse(): bool;

    public function isTrue(): bool;

    public function inverse(): BooleanInterface;

    /**
     * transform.
     *
     * @param mixed $trueString
     * @param mixed $falseString
     *
     * @return StringInterface
     */
    public function transform($trueString, $falseString): StringInterface;

    public function __toBoolean(): bool;
}
