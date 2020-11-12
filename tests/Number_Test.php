<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Pseudo\Number_;
use FightTheIce\Exceptions\InvalidArgumentException;
use FightTheIce\Datatypes\Scalar\Integer_;
use FightTheIce\Datatypes\Scalar\Float_;

final class Number_Test extends TestCase
{
    public function test_construct() {
        $number = new Number_;
        $this->assertSame(0,$number->getValue());
    }

    public function test_construct_exception() {
        $this->expectException(InvalidArgumentException::class);
        $number = new Number_(new stdClass);
    }

    public function test_getValue() {
        $number = new Number_(1);
        $this->assertSame(1,$number->getValue());

        $number = new Number_(1.77);
        $this->assertSame(1.77,$number->getValue());

        $this->assertSame(77,intval('77'));
        $this->assertTrue(is_int((int) '77'));

        $number = new Number_('77');
        $this->assertSame(77,$number->getValue());

        $number = new Number_('1.77');
        $this->assertSame(1.77,$number->getValue());
    }

    public function test_getDatatypeClass() {
        $number= new Number_(1);
        $this->assertInstanceOf(Integer_::class,$number->getDatatypeClass());

        $number = new Number_('1');
        $this->assertInstanceOf(Integer_::class,$number->getDatatypeClass());

        $number = new Number_(1.77);
        $this->assertInstanceOf(Float_::class,$number->getDatatypeClass());

        $number = new Number_('1.77');
        $this->assertInstanceOf(Float_::class,$number->getDatatypeClass());
    }

    public function test_resolve() {
        $number= new Number_(1);
        $this->assertInstanceOf(Integer_::class,$number->resolve());

        $number = new Number_('1');
        $this->assertInstanceOf(Integer_::class,$number->resolve());

        $number = new Number_(1.77);
        $this->assertInstanceOf(Float_::class,$number->resolve());

        $number = new Number_('1.77');
        $this->assertInstanceOf(Float_::class,$number->resolve());
    }
}