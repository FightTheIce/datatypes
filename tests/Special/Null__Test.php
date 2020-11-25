<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Special\Null_;
use FightTheIce\Datatypes\Core\Contracts\DatatypeInterface;
use FightTheIce\Datatypes\Core\Contracts\NullInterface;
use FightTheIce\Datatypes\Core\Contracts\SpecialInterface;
use FightTheIce\Exceptions\InvalidArgumentException;
use FightTheIce\Datatypes\Scalar\Boolean_;

final class Null__Test extends TestCase
{
    public function test_meta()
    {
        $null = new Null_();
        $this->assertInstanceOf(Null_::class, $null);

        $this->assertInstanceOf(NullInterface::class, $null);
        $this->assertInstanceOf(SpecialInterface::class, $null);
        $this->assertInstanceOf(DatatypeInterface::class, $null);

        $this->assertClassHasAttribute('macros', Null_::class);
    }

    public function test_getPrimitiveType()
    {
        $null = new Null_();
        $this->assertEquals('null', $null->getPrimitiveType());
    }

    public function test_getDatatypeCategory()
    {
        $null = new Null_();
        $this->assertEquals('special', $null->getDatatypeCategory());
    }

    public function test_describe()
    {
        $null = new Null_();
        $this->assertEquals('null value', $null->describe());
    }

    public function test_construct_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $null = new Null_(1);
    }

    public function test_hasSubject()
    {
        $null = new Null_();
        $this->assertTrue(method_exists($null, '__toNull'));
    }

    public function test__toNull()
    {
        $null = new Null_();
        $this->assertNull($null->__toNull());
    }

    public function test_isNull()
    {
        $null = new Null_();
        $bool = $null->isNull();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertFalse($bool->isFalse());
    }
}
