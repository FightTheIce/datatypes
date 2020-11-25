<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Special\Resource_;
use FightTheIce\Datatypes\Core\Contracts\DatatypeInterface;
use FightTheIce\Datatypes\Core\Contracts\ResourceInterface;
use FightTheIce\Datatypes\Core\Contracts\SpecialInterface;
use FightTheIce\Exceptions\InvalidArgumentException;
use FightTheIce\Datatypes\Scalar\String_;

final class Resource__Test extends TestCase
{
    public function test_meta()
    {
        $res = new Resource_();
        $this->assertInstanceOf(Resource_::class, $res);

        $this->assertInstanceOf(ResourceInterface::class, $res);
        $this->assertInstanceOf(SpecialInterface::class, $res);
        $this->assertInstanceOf(DatatypeInterface::class, $res);

        $this->assertClassHasAttribute('resource', Resource_::class);
        $this->assertClassHasAttribute('macros', Resource_::class);
    }

    public function test_getPrimitiveType()
    {
        $res = new Resource_();
        $this->assertEquals('resource', $res->getPrimitiveType());
    }

    public function test_getDatatypeCategory()
    {
        $res = new Resource_();
        $this->assertEquals('special', $res->getDatatypeCategory());
    }

    public function test_describe()
    {
        $res = new Resource_();
        $this->assertEquals('resource of type stream', $res->describe());
    }

    public function test_construct_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $res = new Resource_(1);
    }

    public function test_hasSubject()
    {
        $res = new Resource_();
        $this->assertTrue(method_exists($res, '__toResource'));
    }

    public function test_get_type()
    {
        $res  = new Resource_();
        $type = $res->get_type();
        $this->assertIsObject($type);
        $this->assertInstanceOf(String_::class, $type);
        $this->assertSame('stream', $type->__toString());
    }

    public function test__toResource()
    {
        $resource = @\fopen('php://memory', 'rb');

        $res = new Resource_($resource);
        $this->assertSame($resource, $res->__toResource());
    }
}
