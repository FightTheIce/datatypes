<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Complex\Uuid_;
use Ramsey\Uuid\UuidInterface;

final class Uuid_Test extends TestCase
{
    public function test_construct_no_args()
    {
        $uuid = new Uuid_();
        $this->assertTrue(is_string($uuid->__toUuid()));
    }

    public function test_construct_with_uuid()
    {
        $uuid = new Uuid_('1eb25356-44a3-69ee-ab36-38c98603aedf');
        $this->assertSame('1eb25356-44a3-69ee-ab36-38c98603aedf', $uuid->__toUuid());
    }

    public function test_construct_with_int_str()
    {
        $uuid = new Uuid_('40802758989228290647962411573446946527');
        $this->assertSame('1eb25356-44a3-69ee-ab36-38c98603aedf', $uuid->__toUuid());
    }

    public function test_construct_with_int()
    {
        $uuid = new Uuid_(408);
        $this->assertSame('00000000-0000-0000-0000-000000000198', $uuid->__toUuid());
    }

    public function test_getIntegerString()
    {
        $uuid = new Uuid_('1eb25356-44a3-69ee-ab36-38c98603aedf');
        $this->assertSame('40802758989228290647962411573446946527', $uuid->getIntegerString()->__toString());
    }

    public function test_getUuidObj()
    {
        $uuid = new Uuid_();
        $obj  = $uuid->getUuidObj();
        $this->assertInstanceOf(UuidInterface::class, $obj);
    }

    public function test_construct_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $uuid = new Uuid_(new stdClass());
    }

    public function test_getDatatypeCategory()
    {
        $uuid = new Uuid_();
        $this->assertSame('complex', $uuid->getDatatypeCategory());
    }

    public function test_describe()
    {
        $uuid = new Uuid_();
        $this->assertSame('uuid', $uuid->describe());
    }

    public function test_getPrimitiveType()
    {
        $uuid = new Uuid_();
        $this->assertSame('string', $uuid->getPrimitiveType());
    }
}
