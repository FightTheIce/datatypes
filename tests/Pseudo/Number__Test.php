<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Pseudo\Number_;
use FightTheIce\Datatypes\Core\Contracts\PseudoNumberInterface;
use FightTheIce\Datatypes\Core\Contracts\NumberInterface;
use FightTheIce\Datatypes\Core\Contracts\PseudoInterface;
use FightTheIce\Datatypes\Core\Contracts\DatatypeInterface;
use FightTheIce\Datatypes\Core\Contracts\ScalarInterface;
use FightTheIce\Datatypes\Scalar\Boolean_;
use FightTheIce\Datatypes\Scalar\Integer_;
use FightTheIce\Datatypes\Scalar\Float_;
use FightTheIce\Exceptions\InvalidArgumentException;
use Brick\Math\BigNumber;
use Brick\Math\BigInteger;
use Brick\Math\BigDecimal;
use Brick\Math\BigRational;

final class Number__Test extends TestCase
{
    public function test_meta()
    {
        $num = new Number_();
        $this->assertInstanceOf(Number_::class, $num);

        $this->assertInstanceOf(PseudoNumberInterface::class, $num);
        $this->assertInstanceOf(NumberInterface::class, $num);
        $this->assertInstanceOf(PseudoInterface::class, $num);
        $this->assertInstanceOf(DatatypeInterface::class, $num);
        $this->assertInstanceOf(ScalarInterface::class, $num);

        $this->assertClassHasAttribute('concrete', Number_::class);

        $this->assertClassHasAttribute('macros', Number_::class);
    }

    public function test_getPrimitiveType()
    {
        $num = new Number_();
        $this->assertEquals('number', $num->getPrimitiveType());
    }

    public function test_getDatatypeCategory()
    {
        $num = new Number_();
        $this->assertEquals('pseudo', $num->getDatatypeCategory());
    }

    public function test_describe()
    {
        $int = new Number_(0.0);
        $this->assertEquals('zero float', $int->describe());

        $int = new Number_(1.0);
        $this->assertEquals('positive float', $int->describe());

        $int = new Number_(-1.0);
        $this->assertEquals('negative float', $int->describe());

        $int = new Number_(1.8e308);
        $this->assertEquals('infinite float', $int->describe());

        $int = new Number_(acos(8));
        $this->assertEquals('invalid float', $int->describe());

        $int = new Number_(0);
        $this->assertEquals('zero integer', $int->describe());

        $int = new Number_(1);
        $this->assertEquals('positive integer', $int->describe());

        $int = new Number_(-1);
        $this->assertEquals('negative integer', $int->describe());
    }

    public function test_isPositive()
    {
        $int  = new Number_(1.0);
        $bool = $int->isPositive();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertFalse($bool->isFalse());

        $int = new Number_(-1.0);
        $this->assertFalse($int->isPositive()->isTrue());
        $this->assertTrue($int->isPositive()->isFalse());

        $int = new Number_(0.0);
        $this->assertFalse($int->isPositive()->isTrue());

        $int  = new Number_(1);
        $bool = $int->isPositive();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertFalse($bool->isFalse());

        $int = new Number_(-1);
        $this->assertFalse($int->isPositive()->isTrue());
        $this->assertTrue($int->isPositive()->isFalse());

        $int = new Number_(0);
        $this->assertFalse($int->isPositive()->isTrue());
    }

    public function test_isNegative()
    {
        $int  = new Number_(-1.0);
        $bool = $int->isNegative();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertFalse($bool->isFalse());

        $int = new Number_(1.0);
        $this->assertFalse($int->isNegative()->isTrue());
        $this->assertTrue($int->isNegative()->isFalse());

        $int = new Number_(0.0);
        $this->assertFalse($int->isNegative()->isTrue());

        $int  = new Number_(-1);
        $bool = $int->isNegative();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertFalse($bool->isFalse());

        $int = new Number_(1);
        $this->assertFalse($int->isNegative()->isTrue());
        $this->assertTrue($int->isNegative()->isFalse());

        $int = new Number_(0);
        $this->assertFalse($int->isNegative()->isTrue());
    }

    public function test_isZero()
    {
        $int  = new Number_(0.0);
        $bool = $int->isZero();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertFalse($bool->isFalse());

        $int = new Number_(-0.0);
        $this->assertTrue($int->isZero()->isTrue());
        $this->assertFalse($int->isZero()->isFalse());

        $int = new Number_(+0.0);
        $this->assertTrue($int->isZero()->isTrue());
        $this->assertFalse($int->isZero()->isFalse());

        $int = new Number_(-1.0);
        $this->assertFalse($int->isZero()->isTrue());
        $this->assertTrue($int->isZero()->isFalse());

        $int = new Number_(10.0);
        $this->assertFalse($int->isZero()->isTrue());
        $this->assertTrue($int->isZero()->isFalse());

        $int  = new Number_(0);
        $bool = $int->isZero();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertFalse($bool->isFalse());

        $int = new Number_(-0);
        $this->assertTrue($int->isZero()->isTrue());
        $this->assertFalse($int->isZero()->isFalse());

        $int = new Number_(+0);
        $this->assertTrue($int->isZero()->isTrue());
        $this->assertFalse($int->isZero()->isFalse());

        $int = new Number_(-1);
        $this->assertFalse($int->isZero()->isTrue());
        $this->assertTrue($int->isZero()->isFalse());

        $int = new Number_(10);
        $this->assertFalse($int->isZero()->isTrue());
        $this->assertTrue($int->isZero()->isFalse());
    }

    public function test_getNumber()
    {
        $int = new Number_(0.0);
        $this->assertSame(0.0, $int->getNumber());

        $int = new Number_(-100.0);
        $this->assertSame(-100.0, $int->getNumber());

        $int = new Number_(100.0);
        $this->assertSame(100.0, $int->getNumber());

        $int = new Number_(0);
        $this->assertSame(0, $int->getNumber());

        $int = new Number_(-100);
        $this->assertSame(-100, $int->getNumber());

        $int = new Number_(100);
        $this->assertSame(100, $int->getNumber());
    }

    public function test__toFloat()
    {
        $float = new Number_();
        $flt   = $float->__toFloat();
        $this->assertIsObject($flt);
        $this->assertInstanceOf(Float_::class, $flt);
        $this->assertSame(0.00, $flt->getNumber());

        $float = new Number_(1);
        $this->assertSame(1.0, $float->__toFloat()->getNumber());

        $float = new Number_(1.66);
        $this->assertSame(1.66, $float->__toFloat()->getNumber());

        $int   = new Number_(100);
        $float = $int->__toFloat();
        $this->assertIsObject($float);
        $this->assertInstanceOf(Float_::class, $float);
        $this->assertSame(100.0, $float->getNumber());
    }

    public function test___toInteger()
    {
        $float = new Number_(1.66);
        $int   = $float->__toInteger();
        $this->assertIsObject($int);
        $this->assertInstanceOf(Integer_::class, $int);
        $this->assertSame(1, $int->getNumber());

        $float = new Number_(1);
        $this->assertSame(1, $float->__toInteger()->getNumber());

        $int = new Number_();
        $i   = $int->__toInteger();
        $this->assertIsObject($i);
        $this->assertInstanceOf(Integer_::class, $i);
        $this->assertSame(0, $i->getNumber());

        $int = new Number_(100);
        $this->assertSame(100, $int->getNumber());
    }

    public function test_absolute()
    {
        $int = new Number_();
        $abs = $int->absolute();
        $this->assertIsObject($abs);
        $this->assertInstanceOf(Number_::class, $abs);
        $this->assertSame(0, $abs->getNumber());

        $int = new Number_(10.123);
        $this->assertSame(10.123, $int->absolute()->getNumber());

        $int = new Number_(-16.12);
        $this->assertSame(16.12, $int->absolute()->getNumber());

        $int = new Number_();
        $abs = $int->absolute();
        $this->assertIsObject($abs);
        $this->assertInstanceOf(Number_::class, $abs);
        $this->assertSame(0, $abs->getNumber());

        $int = new Number_(100);
        $this->assertSame(100, $int->absolute()->getNumber());

        $int = new Number_(-100);
        $this->assertSame(100, $int->absolute()->getNumber());
    }

    public function test_negated()
    {
        $int = new Number_();
        $neg = $int->negated();
        $this->assertIsObject($neg);
        $this->assertInstanceOf(Number_::class, $neg);
        $this->assertSame(0, $neg->getNumber());

        $int = new Number_(100.123);
        $this->assertSame(-100.123, $int->negated()->getNumber());

        $int = new Number_();
        $neg = $int->negated();
        $this->assertIsObject($neg);
        $this->assertInstanceOf(Number_::class, $neg);
        $this->assertSame(0, $neg->getNumber());

        $int = new Number_(100);
        $this->assertSame(-100, $int->negated()->getNumber());

        $int = new Number_(-100);
        $this->assertSame(100, $int->negated()->getNumber());
    }

    public function test_negativeabsolute()
    {
        $int = new Number_();
        $abs = $int->negativeabsolute();
        $this->assertIsObject($abs);
        $this->assertInstanceOf(Number_::class, $abs);
        $this->assertSame(0, $abs->getNumber());

        $int = new Number_(100.123);
        $this->assertSame(-100.123, $int->negativeabsolute()->getNumber());

        $int = new Number_();
        $abs = $int->negativeabsolute();
        $this->assertIsObject($abs);
        $this->assertInstanceOf(Number_::class, $abs);
        $this->assertSame(0, $abs->getNumber());

        $int = new Number_(100);
        $this->assertSame(-100, $int->negativeabsolute()->getNumber());

        $int = new Number_(-100);
        $this->assertSame(-100, $int->negativeabsolute()->getNumber());
    }

    public function test_math()
    {
        $int  = new Number_(0.0);
        $math = $int->math();

        $this->assertIsObject($math);
        $this->assertInstanceOf(BigNumber::class, $math);
        $this->assertInstanceOf(BigDecimal::class, $math);

        $int  = new Number_(1);
        $math = $int->math();
        $this->assertIsObject($math);
        $this->assertInstanceOf(BigNumber::class, $math);
        $this->assertInstanceOf(BigInteger::class, $math);

        $int  = new Number_('1');
        $math = $int->math();
        $this->assertIsObject($math);
        $this->assertInstanceOf(BigNumber::class, $math);
        $this->assertInstanceOf(BigRational::class, $math);

        $int  = new Number_('1.123');
        $math = $int->math();
        $this->assertIsObject($math);
        $this->assertInstanceOf(BigNumber::class, $math);
        $this->assertInstanceOf(BigRational::class, $math);
    }

    public function test_hasSubject()
    {
        $float = new Number_();
        $this->assertTrue(method_exists($float, '__toFloat'));
        $this->assertTrue(method_exists($float, '__toInteger'));
    }

    public function test_is_float()
    {
        $num  = new Number_(0.0);
        $bool = $num->is_float();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertFalse($bool->isFalse());

        $this->assertFalse($num->is_integer()->isTrue());
    }

    public function test_is_integer()
    {
        $num  = new Number_(100);
        $bool = $num->is_integer();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertFalse($bool->isFalse());

        $this->assertFalse($num->is_float()->isTrue());
    }

    public function test_resolve()
    {
        $num     = new Number_();
        $resolve = $num->resolve();
        $this->assertIsObject($resolve);
        $this->assertInstanceOf(Integer_::class, $resolve);
        $this->assertSame(0, $resolve->getNumber());

        $num     = new Number_(1.5123);
        $resolve = $num->resolve();
        $this->assertIsObject($resolve);
        $this->assertInstanceOf(Float_::class, $resolve);
        $this->assertSame(1.5123, $resolve->getNumber());
    }

    public function test_construct_exception()
    {
        $this->expectException(InvalidArgumentException::class);

        $num = new Number_(new stdClass());
    }
}
