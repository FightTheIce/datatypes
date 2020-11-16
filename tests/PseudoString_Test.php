<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Pseudo\String_ as PseudoString;
use FightTheIce\Datatypes\Scalar\String_;
use FightTheIce\Datatypes\Scalar\UnicodeString_;
use Symfony\Component\String\UnicodeString;

final class PseudoPseudoStringTest extends TestCase
{
    public function test_construct()
    {
        $pstr = new PseudoString();
        $this->assertSame('', $pstr->getValue());
    }

    public function test_construct_exception()
    {
        $this->expectException(\TypeError::class);
        $pstr = new PseudoString(new StdClass());
    }

    public function test_standardstring()
    {
        $pstr = new PseudoString('hello world');
        $this->assertSame('hello world', $pstr->getValue());
    }

    public function test_unicodestring()
    {
        $pstr = new PseudoString('नमस्ते दुनिया');
        $this->assertSame('नमस्ते दुनिया', $pstr->getValue());
    }

    public function test_getValue()
    {
        $pstr = new PseudoString('hello world');
        $this->assertSame('hello world', $pstr->getValue());

        $pstr = new PseudoString('नमस्ते दुनिया');
        $this->assertSame('नमस्ते दुनिया', $pstr->getValue());
    }

    public function test_isUnicode()
    {
        $pstr = new PseudoString('hello world');
        $this->assertFalse($pstr->isUnicode()->isTrue());

        $pstr = new PseudoString('नमस्ते दुनिया');
        $this->assertTrue($pstr->isUnicode()->isTrue());
    }

    public function test_resolve()
    {
        $pstr = new PseudoString('नमस्ते दुनिया');
        $this->assertInstanceOf(UnicodeString_::class, $pstr->resolve());

        $pstr = new PseudoString('hello world');
        $this->assertInstanceOf(String_::class, $pstr->resolve());
    }

    public function test_getDatatypeClass()
    {
        $pstr = new PseudoString('नमस्ते दुनिया');
        $this->assertInstanceOf(UnicodeString_::class, $pstr->getDatatypeClass());

        $pstr = new PseudoString('hello world');
        $this->assertInstanceOf(String_::class, $pstr->getDatatypeClass());
    }

    public function test_ltrim()
    {
        $data = '     Hello World';
        $str  = new PseudoString($data);
        $this->assertSame(ltrim($data), $str->ltrim()->__toString());

        $data = 'Hello World';
        $str  = new PseudoString($data);
        $this->assertSame(ltrim($data, 'H'), $str->ltrim('H')->__toString());

        $data = '     garçon';
        $str  = new PseudoString($data);
        $ustr = new UnicodeString($data);
        $this->assertSame($ustr->trimStart()->__toString(), $str->ltrim()->__toString());

        $data = 'garçon';
        $str  = new PseudoString($data);
        $ustr = new UnicodeString($data);
        $this->assertSame($ustr->trimStart('n')->__toString(), $str->ltrim('n')->__toString());

        $mixedStr = '      Hç';
        $str      = new PseudoString($mixedStr);
        $this->assertSame('Hç', $str->ltrim()->__toString());
        $this->assertInstanceOf(UnicodeString_::class, $str->resolve());

        $mixedStr = 'Hç';
        $str      = new PseudoString($mixedStr);
        $this->assertSame('ç', $str->ltrim('H')->__toString());

        $mixedStr = 'çH';
        $str      = new PseudoString($mixedStr);
        $this->assertSame('H', $str->ltrim('ç')->__toString());
    }

    public function test_rtrim()
    {
        $data = 'Hello World     ';
        $str  = new PseudoString($data);
        $this->assertSame(rtrim($data), $str->rtrim()->__toString());

        $data = 'Hello World';
        $str  = new PseudoString($data);
        $this->assertSame(rtrim($data, 'd'), $str->rtrim('d')->__toString());

        $data = 'garçon     ';
        $str  = new PseudoString($data);
        $ustr = new UnicodeString($data);
        $this->assertSame($ustr->trimEnd()->__toString(), $str->rtrim()->__toString());

        $data = 'garçon';
        $str  = new PseudoString($data);
        $ustr = new UnicodeString($data);
        $this->assertSame($ustr->trimEnd('g')->__toString(), $str->rtrim('g')->__toString());

        $mixedStr = 'Hç    ';
        $str      = new PseudoString($mixedStr);
        $this->assertSame('Hç', $str->rtrim()->__toString());
        $this->assertInstanceOf(UnicodeString_::class, $str->resolve());

        $mixedStr = 'Hç';
        $str      = new PseudoString($mixedStr);
        $this->assertSame('H', $str->rtrim('ç')->__toString());

        $mixedStr = 'çH';
        $str      = new PseudoString($mixedStr);
        $this->assertSame('ç', $str->rtrim('H')->__toString());
    }

    public function test_trim()
    {
        $data = '       Hello World     ';
        $str  = new PseudoString($data);
        $this->assertSame(trim($data), $str->trim()->__toString());

        $data = 'zzHello Worldzz';
        $str  = new PseudoString($data);
        $this->assertSame(trim($data, 'z'), $str->trim('z')->__toString());

        $data = '       œuvre     ';
        $str  = new PseudoString($data);
        $ustr = new UnicodeString($data);
        $this->assertSame($ustr->trim()->__toString(), $str->trim()->__toString());

        $data = 'zzœuvrezz';
        $str  = new PseudoString($data);
        $ustr = new UnicodeString($data);
        $this->assertSame($ustr->trim('z')->__toString(), $str->trim('z')->__toString());
    }

    public function test_substr()
    {
        $data = 'hello world';
        $str  = new PseudoString($data);
        $this->assertSame(substr($data, 2), $str->substr(2)->__toString());

        $data = 'hello world';
        $str  = new PseudoString($data);
        $this->assertSame(substr($data, 0, 5), $str->substr(0, 5)->__toString());

        $data = 'déjà';
        $str  = new PseudoString($data);
        $ustr = new UnicodeString($data);
        $this->assertSame($ustr->slice(1)->__toString(), $str->substr(1)->__toString());

        $data = 'déjà';
        $str  = new PseudoString($data);
        $ustr = new UnicodeString($data);
        $this->assertSame($ustr->slice(0, 1)->__toString(), $str->substr(0, 1)->__toString());
    }

    public function test_strtolower()
    {
        $data = 'HELLO WORLD';
        $str  = new PseudoString($data);
        $this->assertSame(strtolower($data), $str->strtolower()->__toString());

        $data = 'GARÇON';
        $str  = new PseudoString($data);
        $ustr = new UnicodeString($data);
        $this->assertSame($ustr->lower()->__toString(), $str->strtolower()->__toString());
    }

    public function test_strtoupper()
    {
        $data = 'hello world';
        $str  = new PseudoString($data);
        $this->assertSame(strtoupper($data), $str->strtoupper()->__toString());

        $data = 'garçon';
        $str  = new PseudoString($data);
        $ustr = new UnicodeString($data);
        $this->assertSame($ustr->upper()->__toString(), $str->strtoupper()->__toString());
    }

    public function test_is_empty()
    {
        $data = '';
        $str  = new PseudoString($data);
        $this->assertTrue($str->isEmpty()->isTrue());

        $data = 'something';
        $str  = new PseudoString($data);
        $this->assertFalse($str->isEmpty()->isTrue());

        $data = '';
        $str  = new PseudoString($data);
        $this->assertTrue($str->isEmpty()->isTrue());

        $data = 'garçon';
        $str  = new PseudoString($data);
        $this->assertFalse($str->isEmpty()->isTrue());
    }

    public function test__toString()
    {
        $data = 'string';
        $str  = new PseudoString($data);
        $this->assertSame($data, $str->__toString());

        $data = 'garçon';
        $str  = new PseudoString($data);
        $this->assertSame($data, $str->__toString());
    }

    public function test_str_split()
    {
        $data = 'hello world';
        $str  = new PseudoString($data);
        $this->assertSame(str_split($data, 1), $str->str_split());

        $data = 'hello world';
        $str  = new PseudoString($data);
        $this->assertSame(str_split($data, 3), $str->str_split(3));

        $data = '';
        $str  = new PseudoString($data);
        $this->assertSame([], $str->str_split());

        $data = '';
        $str  = new PseudoString($data);
        $this->assertSame([], $str->str_split(2));

        $data = 'नमस्ते';
        $str  = new PseudoString($data);
        $ustr = new UnicodeString($data);
        $this->assertSame($ustr->width(), $str->strlen()->getValue());
    }

    public function test_strlen()
    {
        $data = 'hello world';
        $str  = new PseudoString($data);
        $this->assertSame(strlen($data), $str->strlen()->getValue());

        $data  = 'नमस्ते';
        $str   = new PseudoString($data);
        $ustr  = new UnicodeString($data);
        $udata = [];
        foreach ($ustr->chunk(1) as $key => $value) {
            $udata[] = $value->__toString();
        }

        $this->assertSame($udata, $str->str_split());

        $str   = new PseudoString($data);
        $udata = [];
        foreach ($ustr->chunk(3) as $key => $value) {
            $udata[] = $value->__toString();
        }
        $this->assertSame($udata, $str->str_split(3));

        $data = '';
        $str  = new PseudoString($data);
        $this->assertSame([], $str->str_split());

        $data = '';
        $str  = new PseudoString($data);
        $this->assertSame([], $str->str_split(2));
    }

    public function test_offsetExists()
    {
        $data = '';
        $str  = new PseudoString($data);
        $this->assertFalse($str->offsetExists(0));

        $data = 'a';
        $str  = new PseudoString($data);
        $this->assertTrue($str->offsetExists(0));
        $this->assertFalse($str->offsetExists(1));

        $data = '';
        $str  = new PseudoString($data);
        $this->assertFalse($str->offsetExists(0));

        $data = 'नमस्ते';
        $str  = new PseudoString($data);
        $this->assertTrue($str->offsetExists(3));
        $this->assertFalse($str->offsetExists(5));
    }

    public function test_offsetGet_standard()
    {
        $data = 'a';
        $str  = new PseudoString($data);
        $this->assertSame('a', $str->offsetGet(0));

        $this->expectException(\ErrorException::class);
        $str->offsetGet(1);
    }

    public function test_offsetGet_unicode()
    {
        $data = 'न';
        $str  = new PseudoString($data);
        $this->assertSame('न', $str->offsetGet(0));

        $this->expectException(\ErrorException::class);
        $str->offsetGet(1);
    }

    public function test_offsetSet_standard()
    {
        $str = new PseudoString();
        $str->offsetSet(0, 'a');
        $this->assertSame('a', $str->__toString());

        $str    = new PseudoString();
        $str[0] = 'a';
        $this->assertSame('a', $str->__toString());

        $str    = new PseudoString();
        $str[0] = new class() {
            public function __toString()
            {
                return 'a';
            }
        };
        $this->assertSame('a', $str->__toString());

        $this->expectException(\ErrorException::class);
        $str[2];
    }

    public function test_offsetSet_unicode()
    {
        $str = new PseudoString();
        $str->offsetSet(0, 'a');
        $this->assertSame('a', $str->__toString());

        $str    = new PseudoString();
        $str[0] = 'a';
        $this->assertSame('a', $str->__toString());

        $str    = new PseudoString();
        $str[0] = new class() {
            public function __toString()
            {
                return 'नमस्ते';
            }
        };
        $this->assertSame('नमस्ते', $str->__toString());

        $this->expectException(\ErrorException::class);
        $str[5];
    }

    public function test_offsetSet_object_no_toString()
    {
        $this->expectException(\ErrorException::class);
        $str    = new PseudoString();
        $str[0] = new class() {
            public function moo()
            {
                echo 'Hello';
            }
        };
    }

    public function test_offsetSet_non_numeric_key()
    {
        $this->expectException(\ErrorException::class);
        $str         = new PseudoString();
        $str['name'] = 'hello world';
    }

    public function test_offsetSet_float()
    {
        $this->expectException(\ErrorException::class);
        $str      = new PseudoString();
        $str[0.1] = 'hello world';
    }

    public function test_offsetSet_overwrite()
    {
        $str    = new PseudoString();
        $str[0] = 'a';
        $str[0] = 'b';
        $this->assertSame('b', $str->__toString());
    }

    public function test_offsetSet_greater_than_count_plus_one()
    {
        $this->expectException(\ErrorException::class);
        $str    = new PseudoString();
        $str[2] = 'a';
    }

    public function test_offsetSet_greater_than_count_plus_one_v2()
    {
        $this->expectException(\ErrorException::class);
        $str    = new PseudoString();
        $str[0] = 'a';
        $str[2] = 'a';
    }

    public function test_offsetGet_continue()
    {
        $str    = new PseudoString();
        $str[0] = 'a';
        $str[1] = 'b';
        $str[2] = 'c';
        $this->assertSame('abc', $str->__toString());
    }

    public function test_offsetUnset()
    {
        $str    = new PseudoString();
        $str[0] = 'a';
        $str->offsetUnset(0);

        $this->assertSame('', $str->__toString());

        $str    = new PseudoString();
        $str[0] = 'a';
        $str->offsetUnset(10);

        $this->assertSame('a', $str->__toString());
    }
}
