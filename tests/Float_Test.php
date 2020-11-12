<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Scalar\Float_;
use Brick\Math\BigDecimal;

final class Float_Test extends TestCase
{
    public function test_construct() {
        $float = new Float_();
        $this->assertSame(0.00,$float->getValue());
    }

    public function test_construct_exception()
    {
        $this->expectException(TypeError::class);
        $number = new Float_(new stdClass());
    }

    public function test_standard_num() {
        $float = new Float_(1);
        $this->assertSame(1.00,$float->getValue());
    }

    public function test_getValue() {
        $float = new Float_(1.77);
        $this->assertSame(1.77,$float->getValue());
    }

    public function test_isPositive() {
        $float = new Float_(1);
        $this->assertTrue($float->isPositive());

        $float = new Float_(-1);
        $this->assertFalse($float->isPositive());
    }

    public function test_isNegative() {
        $float = new Float_(1);
        $this->assertFalse($float->isNegative());

        $float = new Float_(-1);
        $this->assertTrue($float->isNegative());
    }

    public function test_absolute() {
        $float = new Float_(1);
        $this->assertSame(1.0,$float->absolute()->getValue());

        $float = new Float_(-1);
        $this->assertSame(1.0,$float->absolute()->getValue());
    }

    public function test_opposite() {
        $float = new Float_(1);
        $this->assertEquals(-1.0,$float->opposite()->getValue());

        $float = new Float_(-1);
        $this->assertSame(1.0,$float->opposite()->getValue());
    }

    public function test_math() {
        $float = new Float_(1.88);
        $this->assertInstanceOf(BigDecimal::class,$float->math());
    }

    public function test__toString() {
        $float = new Float_(1.123456789);
        $this->assertSame('1.123456789',$float->__toString());
    }

    public function test__toFloat() {
        $float = new Float_(1.123456789);
        $this->assertSame($float->getValue(),$float->__toFloat()->getValue());
    }

    public function test__toInteger() {
        $float = new Float_(1.123456789);
        $this->assertSame(1,$float->__toInteger()->getValue());
    }
}