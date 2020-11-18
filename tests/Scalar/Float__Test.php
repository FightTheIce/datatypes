<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Scalar\Float_;
use FightTheIce\Datatypes\Core\Contracts\FloatInterface;
use FightTheIce\Datatypes\Core\Contracts\NumberInterface;
use FightTheIce\Datatypes\Core\Contracts\ScalarInterface;
use FightTheIce\Datatypes\Core\Contracts\DatatypeInterface;
use FightTheIce\Datatypes\Scalar\Boolean_;
use FightTheIce\Datatypes\Scalar\Integer_;
use Brick\Math\BigNumber;
use Brick\Math\BigDecimal;

final class Float_Test extends TestCase
{
    public function test_meta()
    {
        $int = new Float_();
        $this->assertInstanceOf(Float_::class, $int);
        $this->assertInstanceOf(FloatInterface::class, $int);
        $this->assertInstanceOf(NumberInterface::class, $int);

        $this->assertInstanceOf(ScalarInterface::class, $int);
        $this->assertInstanceOf(DatatypeInterface::class, $int);
        $this->assertClassHasAttribute('value', Float_::class);

        $this->assertClassHasAttribute('macros', Float_::class);
    }

    public function test_getPrimitiveType()
    {
        $int = new Float_();
        $this->assertEquals('float', $int->getPrimitiveType());
    }

    public function test_getDatatypeCategory()
    {
        $int = new Float_();
        $this->assertEquals('scalar', $int->getDatatypeCategory());
    }

    public function test_describe()
    {
        $int = new Float_(0);
        $this->assertEquals('zero float', $int->describe());

        $int = new Float_(1);
        $this->assertEquals('positive float', $int->describe());

        $int = new Float_(-1);
        $this->assertEquals('negative float', $int->describe());

        $int = new Float_(1.8e308);
        $this->assertEquals('infinite float', $int->describe());

        $int = new Float_(acos(8));
        $this->assertEquals('invalid float', $int->describe());
    }

    public function test_isPositive()
    {
        $int  = new Float_(1);
        $bool = $int->isPositive();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertFalse($bool->isFalse());

        $int = new Float_(-1);
        $this->assertFalse($int->isPositive()->isTrue());
        $this->assertTrue($int->isPositive()->isFalse());

        $int = new Float_(0);
        $this->assertFalse($int->isPositive()->isTrue());
    }

    public function test_isNegative()
    {
        $int  = new Float_(-1);
        $bool = $int->isNegative();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertFalse($bool->isFalse());

        $int = new Float_(1);
        $this->assertFalse($int->isNegative()->isTrue());
        $this->assertTrue($int->isNegative()->isFalse());

        $int = new Float_(0);
        $this->assertFalse($int->isNegative()->isTrue());
    }

    public function test_isZero()
    {
        $int  = new Float_(0);
        $bool = $int->isZero();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertFalse($bool->isFalse());

        $int = new Float_(-0);
        $this->assertTrue($int->isZero()->isTrue());
        $this->assertFalse($int->isZero()->isFalse());

        $int = new Float_(+0);
        $this->assertTrue($int->isZero()->isTrue());
        $this->assertFalse($int->isZero()->isFalse());

        $int = new Float_(-1);
        $this->assertFalse($int->isZero()->isTrue());
        $this->assertTrue($int->isZero()->isFalse());

        $int = new Float_(10);
        $this->assertFalse($int->isZero()->isTrue());
        $this->assertTrue($int->isZero()->isFalse());
    }

    public function test_getNumber()
    {
        $int = new Float_(0);
        $this->assertSame(0.0, $int->getNumber());

        $int = new Float_(0.0);
        $this->assertSame(0.0, $int->getNumber());

        $int = new Float_(-100);
        $this->assertSame(-100.0, $int->getNumber());

        $int = new Float_(-100.0);
        $this->assertSame(-100.0, $int->getNumber());

        $int = new Float_(100);
        $this->assertSame(100.0, $int->getNumber());

        $int = new Float_(100.0);
        $this->assertSame(100.0, $int->getNumber());
    }

    public function test__toFloat()
    {
        $float = new Float_();
        $flt   = $float->__toFloat();
        $this->assertIsObject($flt);
        $this->assertInstanceOf(Float_::class, $flt);
        $this->assertSame(0.00, $flt->getNumber());

        $float = new Float_(1);
        $this->assertSame(1.0, $float->__toFloat()->getNumber());

        $float = new Float_(1.66);
        $this->assertSame(1.66, $float->__toFloat()->getNumber());
    }

    public function test___toInteger()
    {
        $float = new Float_(1.66);
        $int   = $float->__toInteger();
        $this->assertIsObject($int);
        $this->assertInstanceOf(Integer_::class, $int);
        $this->assertSame(1, $int->getNumber());

        $float = new Float_(1);
        $this->assertSame(1, $float->__toInteger()->getNumber());
    }

    public function test_absolute()
    {
        $int = new Float_();
        $abs = $int->absolute();
        $this->assertIsObject($abs);
        $this->assertInstanceOf(Float_::class, $abs);
        $this->assertSame(0.0, $abs->getNumber());

        $int = new Float_(100);
        $this->assertSame(100.0, $int->absolute()->getNumber());

        $int = new Float_(-100);
        $this->assertSame(100.0, $int->absolute()->getNumber());

        $int = new Float_(10.123);
        $this->assertSame(10.123, $int->absolute()->getNumber());

        $int = new Float_(-16.12);
        $this->assertSame(16.12, $int->absolute()->getNumber());
    }

    public function test_negated()
    {
        $int = new Float_();
        $neg = $int->negated();
        $this->assertIsObject($neg);
        $this->assertInstanceOf(Float_::class, $neg);
        $this->assertSame(0.0, $neg->getNumber());

        $int = new Float_(100);
        $this->assertSame(-100.0, $int->negated()->getNumber());

        $int = new Float_(-100);
        $this->assertSame(100.0, $int->negated()->getNumber());

        $int = new Float_(100.123);
        $this->assertSame(-100.123, $int->negated()->getNumber());
    }

    public function test_negativeabsolute()
    {
        $int = new Float_();
        $abs = $int->negativeabsolute();
        $this->assertIsObject($abs);
        $this->assertInstanceOf(Float_::class, $abs);
        $this->assertSame(0.0, $abs->getNumber());

        $int = new Float_(100);
        $this->assertSame(-100.0, $int->negativeabsolute()->getNumber());

        $int = new Float_(-100);
        $this->assertSame(-100.0, $int->negativeabsolute()->getNumber());

        $int = new Float_(100.123);
        $this->assertSame(-100.123, $int->negativeabsolute()->getNumber());
    }

    public function test_math()
    {
        $int  = new Float_();
        $math = $int->math();

        $this->assertIsObject($math);
        $this->assertInstanceOf(BigNumber::class, $math);
        $this->assertInstanceOf(BigDecimal::class, $math);
    }

    public function test_hasSubject()
    {
        $float = new Float_();
        $this->assertTrue(method_exists($float, '__toFloat'));
    }
}
