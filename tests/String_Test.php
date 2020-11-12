<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Scalar\String_;

final class String_Test extends TestCase
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
        $data = '     Hello World';
        $str  = new String_($data);
        $this->assertSame(ltrim($data), $str->ltrim()->__toString());

        $data = 'Hello World';
        $str  = new String_($data);
        $this->assertSame(ltrim($data, 'H'), $str->ltrim('H')->__toString());
    }

    public function test_rtrim()
    {
        $data = 'Hello World     ';
        $str  = new String_($data);
        $this->assertSame(rtrim($data), $str->rtrim()->__toString());

        $data = 'Hello World';
        $str  = new String_($data);
        $this->assertSame(rtrim($data, 'd'), $str->rtrim('d')->__toString());
    }

    public function test_trim()
    {
        $data = '       Hello World     ';
        $str  = new String_($data);
        $this->assertSame(trim($data), $str->trim()->__toString());

        $data = 'zzHello Worldzz';
        $str  = new String_($data);
        $this->assertSame(trim($data, 'z'), $str->trim('z')->__toString());
    }

    public function test_substr()
    {
        $data = 'hello world';
        $str  = new String_($data);
        $this->assertSame(substr($data, 2), $str->substr(2)->__toString());

        $data = 'hello world';
        $str  = new String_($data);
        $this->assertSame(substr($data, 0, 5), $str->substr(0, 5)->__toString());
    }

    public function test_strtolower()
    {
        $data = 'HELLO WORLD';
        $str  = new String_($data);
        $this->assertSame(strtolower($data), $str->strtolower()->__toString());
    }

    public function test_strtoupper()
    {
        $data = 'hello world';
        $str  = new String_($data);
        $this->assertSame(strtoupper($data), $str->strtoupper()->__toString());
    }

    public function test_is_empty()
    {
        $data = '';
        $str  = new String_($data);
        $this->assertTrue($str->isEmpty());

        $data = 'something';
        $str  = new String_($data);
        $this->assertFalse($str->isEmpty());
    }

    public function test__toString()
    {
        $data = 'string';
        $str  = new String_($data);
        $this->assertSame($data, $str->__toString());
    }

    public function test_str_split()
    {
        $data = 'hello world';
        $str  = new String_($data);
        $this->assertSame(str_split($data, 1), $str->str_split());

        $data = 'hello world';
        $str  = new String_($data);
        $this->assertSame(str_split($data, 3), $str->str_split(3));

        $data = '';
        $str  = new String_($data);
        $this->assertSame([], $str->str_split());

        $data = '';
        $str  = new String_($data);
        $this->assertSame([], $str->str_split(2));
    }

    public function test_strlen()
    {
        $data = 'hello world';
        $str  = new String_($data);
        $this->assertSame(strlen($data), $str->strlen());
    }

    public function test_offsetExists()
    {
        $data = '';
        $str  = new String_($data);
        $this->assertFalse($str->offsetExists(0));

        $data = 'a';
        $str  = new String_($data);
        $this->assertTrue($str->offsetExists(0));
        $this->assertFalse($str->offsetExists(1));
    }

    public function test_offsetGet()
    {
        $data = 'a';
        $str  = new String_($data);
        $this->assertSame('a', $str->offsetGet(0));

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
                return 'a';
            }
        };
        $this->assertSame('a', $str->__toString());

        $this->expectException(\ErrorException::class);
        $str[2];
    }

    public function test_offsetSet_object_no_toString()
    {
        $this->expectException(\ErrorException::class);
        $str    = new String_();
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
        $str         = new String_();
        $str['name'] = 'hello world';
    }

    public function test_offsetSet_float()
    {
        $this->expectException(\ErrorException::class);
        $str      = new String_();
        $str[0.1] = 'hello world';
    }

    public function test_offsetSet_overwrite()
    {
        $str    = new String_();
        $str[0] = 'a';
        $str[0] = 'b';
        $this->assertSame('b', $str->__toString());
    }

    public function test_offsetSet_greater_than_count_plus_one()
    {
        $this->expectException(\ErrorException::class);
        $str    = new String_();
        $str[2] = 'a';
    }

    public function test_offsetSet_greater_than_count_plus_one_v2()
    {
        $this->expectException(\ErrorException::class);
        $str    = new String_();
        $str[0] = 'a';
        $str[2] = 'a';
    }

    public function test_offsetGet_continue()
    {
        $str    = new String_();
        $str[0] = 'a';
        $str[1] = 'b';
        $str[2] = 'c';
        $this->assertSame('abc', $str->__toString());
    }

    public function test_offsetUnset()
    {
        $str    = new String_();
        $str[0] = 'a';
        $str->offsetUnset(0);

        $this->assertSame('', $str->__toString());

        $str    = new String_();
        $str[0] = 'a';
        $str->offsetUnset(10);

        $this->assertSame('a', $str->__toString());
    }
}
