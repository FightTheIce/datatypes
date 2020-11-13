<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Core\Contracts;

use FightTheIce\Datatypes\Scalar\Boolean_;
use FightTheIce\Datatypes\Scalar\Integer_;

interface StringInterface
{
    public function ltrim(string $character_mask = " \t\n\r\0\x0B"): StringInterface;

    public function rtrim(string $character_mask = " \t\n\r\0\x0B"): StringInterface;

    public function trim(string $character_mask = " \t\n\r\0\x0B"): StringInterface;

    public function substr(int $start, ? int $length = null): StringInterface;

    public function strtolower(): StringInterface;

    public function strtoupper(): StringInterface;

    public function isEmpty(): Boolean_;

    public function str_split(int $split_length = 1): array;

    public function strlen(): Integer_;
}
