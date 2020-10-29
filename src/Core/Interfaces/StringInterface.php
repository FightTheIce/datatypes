<?php
declare (strict_types = 1);

namespace FightTheIce\Datatypes\Core\Interfaces;

interface StringInterface {
    public function __toString(): string;

    public function trim($character_mask = " \t\n\r\0\x0B");

    public function ltrim($character_mask = " \t\n\r\0\x0B");

    public function rtrim($character_mask = " \t\n\r\0\x0B");

    public function strtoupper();

    public function strtolower();

    public function substr(int $start,  ? int $length = null);

    public function strlen();
}