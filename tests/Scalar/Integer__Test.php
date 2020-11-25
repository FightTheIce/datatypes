<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Scalar\Integer_;
use FightTheIce\Datatypes\Core\Contracts\IntegerInterface;
use FightTheIce\Datatypes\Core\Contracts\NumberInterface;
use FightTheIce\Datatypes\Core\Contracts\ScalarInterface;
use FightTheIce\Datatypes\Core\Contracts\DatatypeInterface;
use FightTheIce\Datatypes\Scalar\Boolean_;
use FightTheIce\Datatypes\Scalar\Float_;
use Brick\Math\BigNumber;
use Brick\Math\BigInteger;

final class Integer__Test extends TestCase
{
    public function test_meta()
    {
        $int = new Integer_();
        $this->assertInstanceOf(Integer_::class, $int);
        $this->assertInstanceOf(IntegerInterface::class, $int);
        $this->assertInstanceOf(NumberInterface::class, $int);

        $this->assertInstanceOf(ScalarInterface::class, $int);
        $this->assertInstanceOf(DatatypeInterface::class, $int);
        $this->assertClassHasAttribute('value', Integer_::class);

        $this->assertClassHasAttribute('macros', Integer_::class);
    }

    public function test_getPrimitiveType()
    {
        $int = new Integer_();
        $this->assertEquals('integer', $int->getPrimitiveType());
    }

    public function test_getDatatypeCategory()
    {
        $int = new Integer_();
        $this->assertEquals('scalar', $int->getDatatypeCategory());
    }

    public function test_describe()
    {
        $int = new Integer_(0);
        $this->assertEquals('zero integer', $int->describe());

        $int = new Integer_(1);
        $this->assertEquals('positive integer', $int->describe());

        $int = new Integer_(-1);
        $this->assertEquals('negative integer', $int->describe());
    }

    public function test_isPositive()
    {
        $int  = new Integer_(1);
        $bool = $int->isPositive();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertFalse($bool->isFalse());

        $int = new Integer_(-1);
        $this->assertFalse($int->isPositive()->isTrue());
        $this->assertTrue($int->isPositive()->isFalse());

        $int = new Integer_(0);
        $this->assertFalse($int->isPositive()->isTrue());
    }

    public function test_isNegative()
    {
        $int  = new Integer_(-1);
        $bool = $int->isNegative();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertFalse($bool->isFalse());

        $int = new Integer_(1);
        $this->assertFalse($int->isNegative()->isTrue());
        $this->assertTrue($int->isNegative()->isFalse());

        $int = new Integer_(0);
        $this->assertFalse($int->isNegative()->isTrue());
    }

    public function test_isZero()
    {
        $int  = new Integer_(0);
        $bool = $int->isZero();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertFalse($bool->isFalse());

        $int = new Integer_(-0);
        $this->assertTrue($int->isZero()->isTrue());
        $this->assertFalse($int->isZero()->isFalse());

        $int = new Integer_(+0);
        $this->assertTrue($int->isZero()->isTrue());
        $this->assertFalse($int->isZero()->isFalse());

        $int = new Integer_(-1);
        $this->assertFalse($int->isZero()->isTrue());
        $this->assertTrue($int->isZero()->isFalse());

        $int = new Integer_(10);
        $this->assertFalse($int->isZero()->isTrue());
        $this->assertTrue($int->isZero()->isFalse());
    }

    public function test_getNumber()
    {
        $int = new Integer_(0);
        $this->assertSame(0, $int->getNumber());

        $int = new Integer_(-100);
        $this->assertSame(-100, $int->getNumber());

        $int = new Integer_(100);
        $this->assertSame(100, $int->getNumber());
    }

    public function test___toFloat()
    {
        $int   = new Integer_(100);
        $float = $int->__toFloat();
        $this->assertIsObject($float);
        $this->assertInstanceOf(Float_::class, $float);
        $this->assertSame(100.0, $float->getNumber());
    }

    public function test___toInteger()
    {
        $int = new Integer_();
        $i   = $int->__toInteger();
        $this->assertIsObject($i);
        $this->assertInstanceOf(Integer_::class, $i);
        $this->assertSame(0, $i->getNumber());

        $int = new Integer_(100);
        $this->assertSame(100, $int->getNumber());
    }

    public function test_absolute()
    {
        $int = new Integer_();
        $abs = $int->absolute();
        $this->assertIsObject($abs);
        $this->assertInstanceOf(Integer_::class, $abs);
        $this->assertSame(0, $abs->getNumber());

        $int = new Integer_(100);
        $this->assertSame(100, $int->absolute()->getNumber());

        $int = new Integer_(-100);
        $this->assertSame(100, $int->absolute()->getNumber());
    }

    public function test_negated()
    {
        $int = new Integer_();
        $neg = $int->negated();
        $this->assertIsObject($neg);
        $this->assertInstanceOf(Integer_::class, $neg);
        $this->assertSame(0, $neg->getNumber());

        $int = new Integer_(100);
        $this->assertSame(-100, $int->negated()->getNumber());

        $int = new Integer_(-100);
        $this->assertSame(100, $int->negated()->getNumber());
    }

    public function test_negativeabsolute()
    {
        $int = new Integer_();
        $abs = $int->negativeabsolute();
        $this->assertIsObject($abs);
        $this->assertInstanceOf(Integer_::class, $abs);
        $this->assertSame(0, $abs->getNumber());

        $int = new Integer_(100);
        $this->assertSame(-100, $int->negativeabsolute()->getNumber());

        $int = new Integer_(-100);
        $this->assertSame(-100, $int->negativeabsolute()->getNumber());
    }

    public function test_math()
    {
        $int  = new Integer_();
        $math = $int->math();
        $this->assertIsObject($math);
        $this->assertInstanceOf(BigNumber::class, $math);
        $this->assertInstanceOf(BigInteger::class, $math);
    }

    public function test_hasSubject()
    {
        $int = new Integer_();
        $this->assertTrue(method_exists($int, '__toInteger'));
    }
}
