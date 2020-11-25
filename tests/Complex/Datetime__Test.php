<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Complex\Datetime_;
use FightTheIce\Datatypes\Core\Contracts\DatetimeInterface;
use FightTheIce\Datatypes\Core\Contracts\ComplexInterface;
use FightTheIce\Datatypes\Core\Contracts\DatatypeInterface;

final class Datetime__Test extends TestCase
{
    public function test_meta()
    {
        $dt = new Datetime_();
        $this->assertInstanceOf(Datetime_::class, $dt);

        $this->assertInstanceOf(DatetimeInterface::class, $dt);
        $this->assertInstanceOf(ComplexInterface::class, $dt);
        $this->assertInstanceOf(DatatypeInterface::class, $dt);

        $this->assertClassHasAttribute('macros', Datetime_::class);
    }

    public function test_getPrimitiveType()
    {
        $dt = new Datetime_();
        $this->assertEquals('string', $dt->getPrimitiveType());
    }

    public function test_getDatatypeCategory()
    {
        $dt = new Datetime_();
        $this->assertEquals('complex', $dt->getDatatypeCategory());
    }

    public function test_describe()
    {
        $dt = new Datetime_();
        $this->assertEquals('datetime', $dt->describe());
    }
}
