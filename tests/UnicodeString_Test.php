<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Scalar\UnicodeString_ as String_;
use Symfony\Component\String\UnicodeString;

final class UnicodeString_Test extends TestCase
{
    public function test_construct()
    {
        $str = new String_();
        $this->assertSame('', $str->getValue());
    }

    public function test_construct_exception()
    {
        $this->expectException(\TypeError::class);
        $str = new String_(new StdClass());
    }

    public function test_ltrim()
    {
        $data = '     garçon';
        $str  = new String_($data);
        $ustr = new UnicodeString($data);
        $this->assertSame($ustr->trimStart()->__toString(), $str->ltrim()->__toString());

        $data = 'garçon';
        $str  = new String_($data);
        $ustr = new UnicodeString($data);
        $this->assertSame($ustr->trimStart('n')->__toString(), $str->ltrim('n')->__toString());
    }

    public function test_rtrim()
    {
        $data = 'garçon     ';
        $str  = new String_($data);
        $ustr = new UnicodeString($data);
        $this->assertSame($ustr->trimEnd()->__toString(), $str->rtrim()->__toString());

        $data = 'garçon';
        $str  = new String_($data);
        $ustr = new UnicodeString($data);
        $this->assertSame($ustr->trimEnd('g')->__toString(), $str->rtrim('g')->__toString());
    }

    public function test_trim()
    {
        $data = '       œuvre     ';
        $str  = new String_($data);
        $ustr = new UnicodeString($data);
        $this->assertSame($ustr->trim()->__toString(), $str->trim()->__toString());

        $data = 'zzœuvrezz';
        $str  = new String_($data);
        $ustr = new UnicodeString($data);
        $this->assertSame($ustr->trim('z')->__toString(), $str->trim('z')->__toString());
    }

    public function test_substr()
    {
        $data = 'déjà';
        $str  = new String_($data);
        $ustr = new UnicodeString($data);
        $this->assertSame($ustr->slice(1)->__toString(), $str->substr(1)->__toString());

        $data = 'déjà';
        $str  = new String_($data);
        $ustr = new UnicodeString($data);
        $this->assertSame($ustr->slice(0,1)->__toString(), $str->substr(0, 1)->__toString());
    }

    public function test_strtolower()
    {
        $data = 'GARÇON';
        $str  = new String_($data);
        $ustr = new UnicodeString($data);
        $this->assertSame($ustr->lower()->__toString(), $str->strtolower()->__toString());
    }

    public function test_strtoupper()
    {
        $data = 'garçon';
        $str  = new String_($data);
        $ustr = new UnicodeString($data);
        $this->assertSame($ustr->upper()->__toString(), $str->strtoupper()->__toString());
    }

    public function test_is_empty()
    {
        $data = '';
        $str  = new String_($data);
        $this->assertTrue($str->isEmpty());

        $data = 'garçon';
        $str  = new String_($data);
        $this->assertFalse($str->isEmpty());
    }

    public function test__toString()
    {
        $data = 'garçon';
        $str  = new String_($data);
        $this->assertSame($data, $str->__toString());
    }

    public function test_strlen()
    {
        $data = 'garçon';
        $str  = new String_($data);
        $ustr = new UnicodeString($data);
        $this->assertSame($ustr->width(), $str->strlen());
    }
}
