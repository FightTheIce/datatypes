<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Core\Contracts;

interface MathInterface
{
    /**
     * math.
     *
     * @return mixed
     */
    public function math();

    /**
     * __toString
     *
     * @return  string 
     */
    public function __toString(): string;
}
