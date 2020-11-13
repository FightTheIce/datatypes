<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Special\Null_;

final class Null_Test extends TestCase
{
    public function test_is_null()
    {
        $null = new Null_();
        $this->assertNull($null->getValue());
    }
}
