<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Complex\Closure_;
use FightTheIce\Datatypes\Core\Contracts\ClosureInterface;
use FightTheIce\Datatypes\Core\Contracts\ComplexInterface;
use FightTheIce\Datatypes\Core\Contracts\DatatypeInterface;

final class Closure__Test extends TestCase
{
    public function test_meta()
    {
        $null = new Closure_();
        $this->assertInstanceOf(Closure_::class, $null);

        $this->assertInstanceOf(ClosureInterface::class, $null);
        $this->assertInstanceOf(ComplexInterface::class, $null);
        $this->assertInstanceOf(DatatypeInterface::class, $null);

        $this->assertClassHasAttribute('macros', Closure_::class);
    }

    public function test_getPrimitiveType()
    {
        $closure = new Closure_();
        $this->assertEquals('closure', $closure->getPrimitiveType());
    }

    public function test_getDatatypeCategory()
    {
        $closure = new Closure_();
        $this->assertEquals('complex', $closure->getDatatypeCategory());
    }

    public function test_describe()
    {
        $closure = new Closure_();
        $this->assertEquals('closure', $closure->describe());
    }

    public function test__toClosure()
    {
        $exec = function () {};

        $closure = new Closure_($exec);
        $this->assertSame($exec, $closure->__toClosure());
    }
}
