<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Pseudo\Void_;
use FightTheIce\Datatypes\Core\Contracts\VoidInterface;
use FightTheIce\Datatypes\Core\Contracts\PseudoInterface;
use FightTheIce\Datatypes\Core\Contracts\DatatypeInterface;
use FightTheIce\Datatypes\Scalar\Boolean_;

final class Void_Test extends TestCase
{
    public function test_meta()
    {
        $void = new Void_();
        $this->assertInstanceOf(Void_::class, $void);

        $this->assertInstanceOf(VoidInterface::class, $void);
        $this->assertInstanceOf(PseudoInterface::class, $void);
        $this->assertInstanceOf(DatatypeInterface::class, $void);

        $this->assertClassHasAttribute('macros', Void_::class);
    }

    public function test_getPrimitiveType()
    {
        $void = new Void_();
        $this->assertEquals('void', $void->getPrimitiveType());
    }

    public function test_getDatatypeCategory()
    {
        $void = new Void_();
        $this->assertEquals('pseudo', $void->getDatatypeCategory());
    }

    public function test_describe()
    {
        $void= new Void_();
        $this->assertEquals('void', $void->describe());
    }

    public function test__toVoid()
    {
        //$this->expectNotToPerformAssertions();
        $void = new Void_();
        $void->__toVoid();

        //this line is here so on the code coverage report it shows that we did
        //indeed "test" __toVoid... even though the return type is void so nothing
        //really happens
        $this->assertTrue(true);
    }

    public function test_hasSubject()
    {
        $void = new Void_();
        $this->assertTrue(method_exists($void, '__toVoid'));
    }

    public function test_isVoid()
    {
        $void = new Void_();
        $bool = $void->isVoid();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertFalse($bool->isFalse());
    }
}
