<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Core\Contracts;

interface StringInterface extends ScalarInterface
{
    public function __toString(): string;

    public function ltrim(string $character_mask = " \t\n\r\0\x0B"): StringInterface;

    public function rtrim(string $character_mask = " \t\n\r\0\x0B"): StringInterface;

    public function trim(string $character_mask = " \t\n\r\0\x0B"): StringInterface;

    public function substr(int $start, ? int $length = null): StringInterface;

    public function strtolower(): StringInterface;

    public function strtoupper(): StringInterface;

    public function isEmpty(): BooleanInterface;

    public function strlen(): IntegerInterface;

    public function str_split(int $split_length = 1): ArrayInterface;

    /**
     * offsetExists
     *
     * @param   mixed  $offset 
     *
     * @return  bool   
     */
    public function offsetExists($offset): bool;

    /**
     * offsetGet
     *
     * @param   mixed $offset
     * 
     * @return Mixed
     */
    public function offsetGet($offset);

    /**
     * offsetSet
     *
     * @param   mixed  $offset 
     * @param   mixed  $value   
     *
     * @return  void             
     */
    public function offsetSet($offset, $value): void;

    /**
     * offsetUnset
     *
     * @param   mixed  $offset  
     *
     * @return  void 
     */
    public function offsetUnset($offset): void;
}
