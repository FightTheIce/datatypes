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
        $this->assertSame($ustr->slice(0, 1)->__toString(), $str->substr(0, 1)->__toString());
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
        $data = 'नमस्ते';
        $str  = new String_($data);
        $ustr = new UnicodeString($data);
        $this->assertSame($ustr->width(), $str->strlen());
    }

    public function test_str_split()
    {
        $data  = 'नमस्ते';
        $str   = new String_($data);
        $ustr  = new UnicodeString($data);
        $udata = [];
        foreach ($ustr->chunk(1) as $key => $value) {
            $udata[] = $value->__toString();
        }

        $this->assertSame($udata, $str->str_split());

        $str   = new String_($data);
        $udata = [];
        foreach ($ustr->chunk(3) as $key => $value) {
            $udata[] = $value->__toString();
        }
        $this->assertSame($udata, $str->str_split(3));

        $data = '';
        $str  = new String_($data);
        $this->assertSame([], $str->str_split());

        $data = '';
        $str  = new String_($data);
        $this->assertSame([], $str->str_split(2));
    }

    public function test_offsetExists()
    {
        $data = '';
        $str  = new String_($data);
        $this->assertFalse($str->offsetExists(0));

        $data = 'नमस्ते';
        $str  = new String_($data);
        $this->assertTrue($str->offsetExists(3));
        $this->assertFalse($str->offsetExists(5));
    }

    public function test_offsetGet()
    {
        $data = 'न';
        $str  = new String_($data);
        $this->assertSame('न', $str->offsetGet(0));

        $this->expectException(\ErrorException::class);
        $str->offsetGet(1);
    }

    public function test_offsetSet()
    {
        $str = new String_();
        $str->offsetSet(0, 'a');
        $this->assertSame('a', $str->__toString());

        $str    = new String_();
        $str[0] = 'a';
        $this->assertSame('a', $str->__toString());

        $str    = new String_();
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
        $str    = new String_();
        $str[0] = new class() {
            public function moo()
            {
                echo 'नमस्ते';
            }
        };
    }

    public function test_offsetSet_non_numeric_key()
    {
        $this->expectException(\ErrorException::class);
        $str         = new String_();
        $str['name'] = 'नमस्ते';
    }

    public function test_offsetSet_float()
    {
        $this->expectException(\ErrorException::class);
        $str      = new String_();
        $str[0.1] = 'नमस्ते';
    }

    public function test_offsetSet_overwrite()
    {
        //नमस्ते
        $str    = new String_();
        $str[0] = 'न';
        $str[0] = 'ते';
        $this->assertSame('ते', $str->__toString());
    }

    public function test_offsetSet_greater_than_count_plus_one()
    {
        $this->expectException(\ErrorException::class);
        $str    = new String_();
        $str[2] = 'ते';
    }

    public function test_offsetSet_greater_than_count_plus_one_v2()
    {
        $this->expectException(\ErrorException::class);
        $str    = new String_();
        $str[0] = 'ते';
        $str[2] = 'ते';
    }

    public function test_offsetGet_continue()
    {
        //नमस्ते
        $str    = new String_();
        $str[0] = 'न';
        $str[1] = 'म';
        $str[2] = 'स्ते';
        $this->assertSame('नमस्ते', $str->__toString());
    }

    public function test_offsetUnset()
    {
        $str    = new String_();
        $str[0] = 'न';
        $str->offsetUnset(0);

        $this->assertSame('', $str->__toString());

        $str    = new String_();
        $str[0] = 'न';
        $str->offsetUnset(10);

        $this->assertSame('न', $str->__toString());
    }
}
