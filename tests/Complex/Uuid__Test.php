<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Complex\Uuid_;
use FightTheIce\Datatypes\Core\Contracts\UuidInterface;
use FightTheIce\Datatypes\Core\Contracts\ComplexInterface;
use FightTheIce\Datatypes\Core\Contracts\DatatypeInterface;
use Ramsey\Uuid\UuidInterface as RUuidInterface;

final class Uuid__Test extends TestCase
{
    public function test_meta()
    {
        $uuid = new Uuid_();
        $this->assertInstanceOf(Uuid_::class, $uuid);

        $this->assertInstanceOf(UuidInterface::class, $uuid);
        $this->assertInstanceOf(ComplexInterface::class, $uuid);
        $this->assertInstanceOf(DatatypeInterface::class, $uuid);

        $this->assertClassHasAttribute('macros', Uuid_::class);
    }

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
        $this->assertInstanceOf(RUuidInterface::class, $obj);
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
