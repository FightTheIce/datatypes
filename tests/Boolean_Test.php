<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Scalar\Boolean_;


final class Boolean_Test extends TestCase
{
    public function test_construct() {
        $bool = new Boolean_();
        $this->assertFalse($bool->getValue());
    }

    public function test_construct_true() {
        $bool = new Boolean_(true);
        $this->assertTrue($bool->getValue());
    }

    public function test_construct_false() {
        $bool = new Boolean_(false);
        $this->assertFalse($bool->getValue());
    }

    public function test_construct_exception() {
        $this->expectException(\TypeError::class);
        $bool = new Boolean_(new StdClass);
    }

    public function test_isTrue() {
        $bool = new Boolean_(false);
        $this->assertFalse($bool->isTrue());
        $this->assertTrue($bool->isFalse());

        $bool = new Boolean_(true);
        $this->assertTrue($bool->isTrue());
        $this->assertFalse($bool->isFalse());
    }

    public function test_isFalse() {
        $bool = new Boolean_(false);
        $this->assertFalse($bool->isTrue());
        $this->assertTrue($bool->isFalse());

        $bool = new Boolean_(true);
        $this->assertTrue($bool->isTrue());
        $this->assertFalse($bool->isFalse());
    }

    public function test_inverse() {
        $bool = new Boolean_(false);
        $this->assertTrue($bool->inverse()->getValue());

        $bool = new Boolean_(true);
        $this->assertFalse($bool->inverse()->getValue());
    }

    public function test_transform() {
        $bool = new Boolean_(false);
        $this->assertSame('false',$bool->transform('true','false'));

        $bool = new Boolean_(true);
        $this->assertSame('true',$bool->transform('true','false'));
    }
}