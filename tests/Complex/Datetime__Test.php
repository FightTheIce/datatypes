<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Complex\Datetime_;

final class Datetime_Test extends TestCase
{
    public function test_getPrimitiveType()
    {
        $dt = new Datetime_();
        $this->assertSame('string', $dt->getPrimitiveType());
    }

    public function test_getDatatypeCategory()
    {
        $dt = new Datetime_();
        $this->assertSame('complex', $dt->getDatatypeCategory());
    }

    public function test_describe()
    {
        $dt = new Datetime_();
        $this->assertSame('datetime', $dt->describe());
    }
}
