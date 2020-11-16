<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Pseudo\Number_;
use FightTheIce\Exceptions\InvalidArgumentException;
use FightTheIce\Datatypes\Scalar\Integer_;
use FightTheIce\Datatypes\Scalar\Float_;
use Brick\Math\BigInteger;
use Brick\Math\BigDecimal;

final class Number_Test extends TestCase
{
    public function test_construct()
    {
        $number = new Number_();
        $this->assertSame(0, $number->getValue());
    }

    public function test_construct_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $number = new Number_(new stdClass());
    }

    public function test_getValue()
    {
        $number = new Number_(1);
        $this->assertSame(1, $number->getValue());

        $number = new Number_(1.77);
        $this->assertSame(1.77, $number->getValue());

        $this->assertSame(77, intval('77'));
        $this->assertTrue(is_int((int) '77'));

        $number = new Number_('77');
        $this->assertSame(77, $number->getValue());

        $number = new Number_('1.77');
        $this->assertSame(1.77, $number->getValue());

        $int = new Number_(1);
        $this->assertSame(1, $int->getValue());

        $float = new Number_(1.77);
        $this->assertSame(1.77, $float->getValue());
    }

    public function test_getDatatypeClass()
    {
        $number= new Number_(1);
        $this->assertInstanceOf(Integer_::class, $number->getDatatypeClass());

        $number = new Number_('1');
        $this->assertInstanceOf(Integer_::class, $number->getDatatypeClass());

        $number = new Number_(1.77);
        $this->assertInstanceOf(Float_::class, $number->getDatatypeClass());

        $number = new Number_('1.77');
        $this->assertInstanceOf(Float_::class, $number->getDatatypeClass());
    }

    public function test_resolve()
    {
        $number= new Number_(1);
        $this->assertInstanceOf(Integer_::class, $number->resolve());

        $number = new Number_('1');
        $this->assertInstanceOf(Integer_::class, $number->resolve());

        $number = new Number_(1.77);
        $this->assertInstanceOf(Float_::class, $number->resolve());

        $number = new Number_('1.77');
        $this->assertInstanceOf(Float_::class, $number->resolve());
    }

    public function test_standard_num()
    {
        $int = new Number_(1);
        $this->assertSame(1, $int->getValue());

        $float = new Number_(1.00);
        $this->assertSame(1.00, $float->getValue());
    }

    public function test_isPositive()
    {
        $int = new Number_(1);
        $this->assertTrue($int->isPositive()->isTrue());

        $int = new Number_(-1);
        $this->assertFalse($int->isPositive()->isTrue());

        $float = new Number_(1);
        $this->assertTrue($float->isPositive()->isTrue());

        $float = new Number_(-1);
        $this->assertFalse($float->isPositive()->isTrue());
    }

    public function test_isNegative()
    {
        $int = new Number_(1);
        $this->assertFalse($int->isNegative()->isTrue());

        $int = new Number_(-1);
        $this->assertTrue($int->isNegative()->isTrue());

        $float = new Number_(1);
        $this->assertFalse($float->isNegative()->isTrue());

        $float = new Number_(-1);
        $this->assertTrue($float->isNegative()->isTrue());
    }

    public function test_absolute()
    {
        $int = new Number_(1);
        $this->assertSame(1, $int->absolute()->getValue());

        $int = new Number_(-1);
        $this->assertSame(1, $int->absolute()->getValue());

        $float = new Number_(1.0);
        $this->assertSame(1.0, $float->absolute()->getValue());

        $float = new Number_(-1.0);
        $this->assertSame(1.0, $float->absolute()->getValue());
    }

    public function test_opposite()
    {
        $int = new Number_(1);
        $this->assertEquals(-1, $int->opposite()->getValue());

        $int = new Number_(-1);
        $this->assertSame(1, $int->opposite()->getValue());

        $float = new Number_(1.0);
        $this->assertEquals(-1.0, $float->opposite()->getValue());

        $float = new Number_(-1.0);
        $this->assertSame(1.0, $float->opposite()->getValue());
    }

    public function test_math()
    {
        $int = new Number_(1);
        $this->assertInstanceOf(BigInteger::class, $int->math());

        $float = new Number_(1.88);
        $this->assertInstanceOf(BigDecimal::class, $float->math());
    }

    public function test__toString()
    {
        $int = new Number_(123456789);
        $this->assertSame('123456789', $int->__toString());

        $float = new Number_(1.123456789);
        $this->assertSame('1.123456789', $float->__toString());
    }

    public function test__toFloat()
    {
        $int = new Number_(123456789);
        $this->assertSame(123456789.0, $int->__toFloat()->getValue());

        $float = new Number_(1.63456789);
        $this->assertSame($float->getValue(), $float->__toFloat()->getValue());
    }

    public function test__toInteger()
    {
        $int = new Number_(123456789);
        $this->assertSame(123456789, $int->__toInteger()->getValue());

        $float = new Number_(1.123456789);
        $this->assertSame(1, $float->__toInteger()->getValue());
    }

    public function test_isInteger()
    {
        $number = new Number_(-1);
        $this->assertTrue($number->isInteger()->isTrue());
        $this->assertFalse($number->isInteger()->isFalse());

        $number = new Number_(1.0123);
        $this->assertFalse($number->isInteger()->isTrue());
        $this->assertTrue($number->isInteger()->isFalse());
    }

    public function test_isFloat()
    {
        $number = new Number_(-1.2334);
        $this->assertTrue($number->isFloat()->isTrue());
        $this->assertFalse($number->isFloat()->isFalse());

        $number = new Number_(1);
        $this->assertFalse($number->isFloat()->isTrue());
        $this->assertTrue($number->isFloat()->isFalse());
    }
}
