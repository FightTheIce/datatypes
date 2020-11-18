<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Compound\Object_;
use FightTheIce\Datatypes\Core\Contracts\CompoundInterface;
use FightTheIce\Datatypes\Core\Contracts\DatatypeInterface;
use FightTheIce\Datatypes\Core\Contracts\ObjectInterface;
use FightTheIce\Exceptions\InvalidArgumentException;
use FightTheIce\Datatypes\Scalar\String_;
use FightTheIce\Datatypes\Core\Contracts\StringInterface;
use FightTheIce\Datatypes\Scalar\Integer_;
use FightTheIce\Datatypes\Core\Contracts\IntegerInterface;

final class Object_Test extends TestCase
{
    public function test_meta()
    {
        $obj = new Object_();
        $this->assertInstanceOf(Object_::class, $obj);

        $this->assertInstanceOf(ObjectInterface::class, $obj);
        $this->assertInstanceOf(CompoundInterface::class, $obj);
        $this->assertInstanceOf(DatatypeInterface::class, $obj);

        $this->assertClassHasAttribute('macros', Object_::class);
    }

    public function test_getPrimitiveType()
    {
        $obj = new Object_();
        $this->assertEquals('object', $obj->getPrimitiveType());
    }

    public function test_getDatatypeCategory()
    {
        $obj = new Object_();
        $this->assertEquals('compound', $obj->getDatatypeCategory());
    }

    public function test_describe()
    {
        $obj = new Object_();
        $this->assertEquals('object of class stdClass', $obj->describe());

        $obj = new Object_($this);
        $this->assertEquals('object of class Object_Test', $obj->describe());

        /*
        $aclass = new class() {
            function cow() {
                echo 'moo';
            }
        };

        $obj = new Object_($aclass);
        $this->assertEquals('object of class Object_Test',$obj->describe());
        */

        $afunc = function () {
            echo 'Hello';
        };
        $obj = new Object_($afunc);
        $this->assertEquals('object of class Closure', $obj->describe());
    }

    public function test_construct_exception()
    {
        $this->expectException(InvalidArgumentException::class);

        new Object_(1);
    }

    public function test__toObject()
    {
        $obj = new Object_(new stdClass());
        $this->assertEquals(new stdClass(), $obj->__toObject());

        $obj = new Object_($this);
        $this->assertSame($this, $obj->__toObject());
    }

    public function test_getReflection()
    {
        $obj  = new Object_($this);
        $refl = $obj->getReflection();
        $this->assertInstanceOf(ReflectionClass::class, $refl);

        $closure = function () {
            echo 'Hello World';
        };
        $obj = new Object_($closure);
        $this->assertInstanceOf(ReflectionFunction::class, $obj->getReflection());
    }

    public function test_getHash()
    {
        $obj  = new Object_($this);
        $hash = $obj->getHash();
        $this->assertIsObject($hash);
        $this->assertInstanceOf(StringInterface::class, $hash);
        $this->assertInstanceOf(String_::class, $hash);
        $this->assertSame(spl_object_hash($this), $hash->__toString());
    }

    public function test_getId()
    {
        $obj = new Object_($this);
        $id  = $obj->getId();
        $this->assertIsObject($id);
        $this->assertInstanceOf(IntegerInterface::class, $id);
        $this->assertInstanceOf(Integer_::class, $id);
        //$this->assertSame($id->getNumber(),spl_object_hash($this));
    }

    public function test_hasSubject()
    {
        $obj = new Object_();
        $this->assertTrue(method_exists($obj, '__toObject'));
    }
}
