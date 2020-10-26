<?php

namespace FightTheIce\Datatypes\Core;

interface StringInterface {
    public function trim();

    public function ltrim();

    public function rtrim();

    //substr ( string $string , int $start [, int $length ] ) : string
    public function substr(int $start,  ? int $length = null);

    public function __toString();

    public function strlen();
}