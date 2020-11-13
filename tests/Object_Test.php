<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Compounds\Object_;

final class Object_Test extends TestCase
{
    public function test__construct_exception()
    {
        $this->expectException(\FightTheIce\Exceptions\InvalidArgumentException::class);
        $obj = new Object_('');
    }

    public function test__construct()
    {
        $obj = new Object_($this);
        $this->assertSame($this, $obj->resolve());
    }

    public function test_getValue()
    {
        $obj = new Object_($this);
        $this->assertSame($this, $obj->getValue());
    }

    public function test_getReflection()
    {
        $obj = new Object_($this);
        $this->assertInstanceOf(\ReflectionClass::class, $obj->getReflection());

        $obj = new Object_(function () {
            echo 'Hello';
        });
        $this->assertInstanceOf(\ReflectionFunction::class, $obj->getReflection());
    }

    public function test_resolve()
    {
        $obj = new Object_($this);
        $this->assertSame($this, $obj->resolve());
    }

    public function test_getHash()
    {
        $obj = new Object_($this);
        $this->assertEquals(spl_object_hash($this), $obj->getHash()->__toString());
    }

    public function test_getId()
    {
        $obj = new Object_($this);
        $this->assertEquals(spl_object_id($this), $obj->getId()->getValue());
    }
}
