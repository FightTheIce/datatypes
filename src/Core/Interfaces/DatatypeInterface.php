<?php
declare (strict_types = 1);

namespace FightTheIce\Datatypes\Core\Interfaces;

interface DatatypeInterface {
    /**
     * getType
     * @return string
     */
    public function getType(): string;

    /**
     * getValue
     * @return mixed
     */
    public function getValue();
}