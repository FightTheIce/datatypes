<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Scalar\Boolean_;
use FightTheIce\Datatypes\Core\Contracts\ScalarInterface;
use FightTheIce\Datatypes\Core\Contracts\DatatypeInterface;
use FightTheIce\Datatypes\Scalar\String_;

final class Boolean_Test extends TestCase
{
    public function test_meta()
    {
        $bool = new Boolean_();
        $this->assertInstanceOf(Boolean_::class, $bool);

        $this->assertInstanceOf(ScalarInterface::class, $bool);
        $this->assertInstanceOf(DatatypeInterface::class, $bool);
        $this->assertClassHasAttribute('value', Boolean_::class);

        $this->assertClassHasAttribute('macros', Boolean_::class);
    }

    public function test_getPrimitiveType()
    {
        $bool = new Boolean_();
        $this->assertEquals('boolean', $bool->getPrimitiveType());
    }

    public function test_getDatatypeCategory()
    {
        $bool = new Boolean_();
        $this->assertEquals('scalar', $bool->getDatatypeCategory());
    }

    public function test_describe()
    {
        $bool = new Boolean_(true);
        $this->assertEquals('boolean true', $bool->describe());

        $bool = new Boolean_(false);
        $this->assertEquals('boolean false', $bool->describe());
    }

    public function test_isFalse()
    {
        $bool = new Boolean_(false);
        $this->assertTrue($bool->isFalse());
        $this->assertFalse($bool->isTrue());
    }

    public function test_isTrue()
    {
        $bool = new Boolean_(true);
        $this->assertTrue($bool->isTrue());
        $this->assertFalse($bool->isFalse());
    }

    public function test_inverse()
    {
        $bool = new Boolean_(true);
        $this->assertTrue($bool->isTrue());
        $this->assertFalse($bool->isFalse());

        $bool = $bool->inverse();
        $this->assertTrue($bool->isFalse());
        $this->assertFalse($bool->isTrue());
    }

    public function test_transform()
    {
        $bool      = new Boolean_(true);
        $transform = $bool->transform('true', 'false');
        $this->assertIsObject($transform);
        $this->assertInstanceOf(String_::class, $transform);
        $this->assertSame('true', $transform->__toString());

        $bool = new Boolean_(false);
        $this->assertSame('false', $bool->transform('true', 'false')->__toString());

        $bool      = new Boolean_(true);
        $transform = $bool->transform(new String_('true'), new String_('false'));
        $this->assertSame('true', $transform->__toString());

        $bool      = new Boolean_(false);
        $transform = $bool->transform(new String_('true'), new String_('false'));
        $this->assertSame('false', $transform->__toString());
    }

    public function test_transform_exception1()
    {
        $this->expectException(InvalidArgumentException::class);

        $bool = new Boolean_(true);
        $bool->transform(new stdClass(), 'false');
    }

    public function test_transform_exception2()
    {
        $this->expectException(InvalidArgumentException::class);

        $bool = new Boolean_(true);
        $bool->transform(1, 'false');
    }

    public function test_transform_exception3()
    {
        $this->expectException(InvalidArgumentException::class);

        $bool = new Boolean_(true);
        $bool->transform('true', new stdClass());
    }

    public function test_transform_exception4()
    {
        $this->expectException(InvalidArgumentException::class);

        $bool = new Boolean_(true);
        $bool->transform('true', 1);
    }

    public function test_hasSubject()
    {
        $bool = new Boolean_();
        $this->assertTrue(method_exists($bool, '__toBoolean'));
    }

    public function test__toBoolean()
    {
        $bool = new Boolean_();
        $this->assertFalse($bool->__toBoolean());

        $bool = new Boolean_(false);
        $this->assertFalse($bool->__toBoolean());

        $bool = new Boolean_(true);
        $this->assertTrue($bool->__toBoolean());
    }
}
