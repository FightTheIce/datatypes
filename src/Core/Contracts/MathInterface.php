<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Core\Contracts;

use FightTheIce\Datatypes\Scalar\Boolean_;
use FightTheIce\Datatypes\Scalar\Integer_;
use FightTheIce\Datatypes\Scalar\Float_;
use FightTheIce\Datatypes\Pseudo\Number_;

interface MathInterface extends DatatypeInterface
{
    /**
     * math.
     *
     * @return mixed
     */
    public function math();

    /**
     * __toString.
     *
     * @return string
     */
    public function __toString(): string;

    /**
     * __toFloat.
     *
     * @return Float_|Number_
     */
    public function __toFloat(): MathInterface;

    /**
     * __toInteger.
     *
     * @return Integer_|Number_
     */
    public function __toInteger(): MathInterface;

    public function isPositive(): Boolean_;

    public function isNegative(): Boolean_;

    /**
     * absolute.
     *
     * @return Float_|Integer_|Number_
     */
    public function absolute();

    /**
     * absolute.
     *
     * @return Float_|Integer_|Number_
     */
    public function opposite();

    /**
     * getValue.
     *
     * @return float|int
     */
    public function getValue();
}
