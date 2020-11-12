<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Scalar\Integer_;
use Brick\Math\BigInteger;

final class Integer_Test extends TestCase
{
    public function test_construct() {
        $int = new Integer_();
        $this->assertSame(0,$int->getValue());
    }

    public function test_construct_exception()
    {
        $this->expectException(TypeError::class);
        $number = new Integer_(new stdClass());
    }

    public function test_standard_num() {
        $int = new Integer_(1);
        $this->assertSame(1,$int->getValue());
    }

    public function test_getValue() {
        $int = new Integer_(1);
        $this->assertSame(1,$int->getValue());
    }

    public function test_isPositive() {
        $int = new Integer_(1);
        $this->assertTrue($int->isPositive());

        $int = new Integer_(-1);
        $this->assertFalse($int->isPositive());
    }

    public function test_isNegative() {
        $int = new Integer_(1);
        $this->assertFalse($int->isNegative());

        $int = new Integer_(-1);
        $this->assertTrue($int->isNegative());
    }

    public function test_absolute() {
        $int = new Integer_(1);
        $this->assertSame(1,$int->absolute()->getValue());

        $int = new Integer_(-1);
        $this->assertSame(1,$int->absolute()->getValue());
    }

    public function test_opposite() {
        $int = new Integer_(1);
        $this->assertEquals(-1,$int->opposite()->getValue());

        $int = new Integer_(-1);
        $this->assertSame(1,$int->opposite()->getValue());
    }

    public function test_math() {
        $int = new Integer_(1);
        $this->assertInstanceOf(BigInteger::class,$int->math());
    }

    public function test__toString() {
        $int = new Integer_(123456789);
        $this->assertSame('123456789',$int->__toString());
    }

    public function test__toFloat() {
        $int = new Integer_(123456789);
        $this->assertSame(123456789.0,$int->__toFloat()->getValue());
    }

    public function test__toInteger() {
        $int = new Integer_(123456789);
        $this->assertSame(123456789,$int->__toInteger()->getValue());
    }
}