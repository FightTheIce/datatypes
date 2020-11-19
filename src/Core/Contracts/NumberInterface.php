<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Core\Contracts;

use Brick\Math\BigNumber;

interface NumberInterface extends ScalarInterface
{
    public function isPositive(): BooleanInterface;

    public function isNegative(): BooleanInterface;

    public function isZero(): BooleanInterface;

    /**
     * getNumber.
     *
     * @return int|float|string
     */
    public function getNumber();

    public function __toFloat(): FloatInterface;

    public function __toInteger(): IntegerInterface;

    public function absolute(): NumberInterface;

    public function negated(): NumberInterface;

    public function negativeabsolute(): NumberInterface;

    public function math(): BigNumber;
}
