<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Pseudo\String_ as PseudoString;
use FightTheIce\Datatypes\Scalar\String_;
use FightTheIce\Datatypes\Scalar\UnicodeString_;


final class PseudoString_Test extends TestCase
{
    public function test_construct() {
        $pstr = new PseudoString();
        $this->assertSame('',$pstr->getValue());
    }

    public function test_construct_exception() {
        $this->expectException(\TypeError::class);
        $pstr = new PseudoString(new StdClass);
    }

    public function test_standardstring() {
        $pstr = new PseudoString('hello world');
        $this->assertSame('hello world',$pstr->getValue());
    }

    public function test_unicodestring() {
        $pstr = new PseudoString('नमस्ते दुनिया');
        $this->assertSame('नमस्ते दुनिया',$pstr->getValue());
    }

    public function test_getValue() {
        $pstr = new PseudoString('hello world');
        $this->assertSame('hello world',$pstr->getValue());

        $pstr = new PseudoString('नमस्ते दुनिया');
        $this->assertSame('नमस्ते दुनिया',$pstr->getValue());
    }

    public function test_isUnicode() {
        $pstr = new PseudoString('hello world');
        $this->assertFalse($pstr->isUnicode());

        $pstr = new PseudoString('नमस्ते दुनिया');
        $this->assertTrue($pstr->isUnicode());
    }

    public function test_resolve() {
        $pstr = new PseudoString('नमस्ते दुनिया');
        $this->assertInstanceOf(UnicodeString_::class,$pstr->resolve());

        $pstr = new PseudoString('hello world');
        $this->assertInstanceOf(String_::class,$pstr->resolve());
    }

    public function test_getDatatypeClass() {
        $pstr = new PseudoString('नमस्ते दुनिया');
        $this->assertInstanceOf(UnicodeString_::class,$pstr->getDatatypeClass());

        $pstr = new PseudoString('hello world');
        $this->assertInstanceOf(String_::class,$pstr->getDatatypeClass());
    }
}