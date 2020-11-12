<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Scalar\Uuid_;

final class Uuid_Test extends TestCase
{
    public function test_construct_no_args() {
        $uuid = new Uuid_;
        $this->assertTrue(is_string($uuid->getValue()));
    }

    public function test_construct_with_uuid() {
        $uuid = new Uuid_('1eb25356-44a3-69ee-ab36-38c98603aedf');
        $this->assertSame('1eb25356-44a3-69ee-ab36-38c98603aedf',$uuid->getValue());
    }

    public function test_construct_with_intstr() {
        $uuid = new Uuid_('40802758989228290647962411573446946527');
        $this->assertSame('1eb25356-44a3-69ee-ab36-38c98603aedf',$uuid->getValue());
    }

    public function test_construct_with_int() {
        $uuid = new Uuid_(408);
        $this->assertSame('00000000-0000-0000-0000-000000000198',$uuid->getValue());
    }

    public function test_getIntegerString() {
        $uuid = new Uuid_('1eb25356-44a3-69ee-ab36-38c98603aedf');
        $this->assertSame('40802758989228290647962411573446946527',$uuid->getIntegerString());
    }

    public function test__toString() {
        $uuid = new Uuid_('1eb25356-44a3-69ee-ab36-38c98603aedf');
        $this->assertSame('1eb25356-44a3-69ee-ab36-38c98603aedf',$uuid->__toString());
    }
}