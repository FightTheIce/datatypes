<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Scalar\String_;
use FightTheIce\Datatypes\Core\Contracts\ScalarInterface;
use FightTheIce\Datatypes\Core\Contracts\DatatypeInterface;
use FightTheIce\Exceptions\UnexpectedValueException;
use FightTheIce\Datatypes\Scalar\Boolean_;
use FightTheIce\Datatypes\Scalar\Integer_;
use FightTheIce\Datatypes\Compound\Array_;
use FightTheIce\Exceptions\LogicException;

final class String__Test extends TestCase
{
    public function test_meta()
    {
        $str = new String_();
        $this->assertInstanceOf(String_::class, $str);

        $this->assertInstanceOf(ScalarInterface::class, $str);
        $this->assertInstanceOf(DatatypeInterface::class, $str);
        $this->assertClassHasAttribute('value', String_::class);

        $this->assertClassHasAttribute('macros', String_::class);
    }

    public function test_getPrimitiveType()
    {
        $str = new String_();
        $this->assertEquals('string', $str->getPrimitiveType());
    }

    public function test_getDatatypeCategory()
    {
        $str = new String_();
        $this->assertEquals('scalar', $str->getDatatypeCategory());
    }

    public function test_describe()
    {
        $str = new String_();
        $this->assertEquals('empty string', $str->describe());

        $str = new String_('strtolower');
        $this->assertEquals('callable string', $str->describe());

        $str = new String_('12345');
        $this->assertEquals('numeric string', $str->describe());

        $str = new String_('hello world');
        $this->assertEquals('string', $str->describe());
    }

    public function test__toString()
    {
        $str = new String_();
        $this->assertEquals('', $str->__toString());

        $str = new String_('Hello World');
        $this->assertEquals('Hello World', $str->__toString());
    }

    public function test_ltrim()
    {
        $str   =  new String_();
        $ltrim = $str->ltrim();
        $this->assertIsObject($ltrim);
        $this->assertInstanceOf(String_::class, $ltrim);
        $this->assertNotSame($str, $ltrim);
        $this->assertEquals('', $ltrim->__toString());

        $str = new String_('         Hello World');
        $this->assertEquals('Hello World', $str->ltrim()->__toString());

        $str=  new String_('zzzzzzzzzzHello World');
        $this->assertEquals('Hello World', $str->ltrim('z')->__toString());
    }

    public function test_rtrim()
    {
        $str   =  new String_();
        $rtrim = $str->rtrim();
        $this->assertIsObject($rtrim);
        $this->assertInstanceOf(String_::class, $rtrim);
        $this->assertNotSame($str, $rtrim);
        $this->assertEquals('', $rtrim->__toString());

        $str = new String_('Hello World              ');
        $this->assertEquals('Hello World', $str->rtrim()->__toString());

        $str=  new String_('Hello Worldzzzzzzzz');
        $this->assertEquals('Hello World', $str->rtrim('z')->__toString());
    }

    public function test_trim()
    {
        $str  = new String_();
        $trim = $str->trim();
        $this->assertIsObject($trim);
        $this->assertInstanceOf(String_::class, $trim);
        $this->assertNotSame($trim, $str);
        $this->assertEquals('', $trim->__toString());

        $str = new String_('     Hello World    ');
        $this->assertEquals('Hello World', $str->trim()->__toString());

        $str = new String_('zzzzHello Worldzzzzz');
        $this->assertEquals('Hello World', $str->trim('z')->__toString());
    }

    public function test_substr()
    {
        $str    = new String_('Hello World');
        $substr = $str->substr(0);
        $this->assertIsObject($substr);
        $this->assertInstanceOf(String_::class, $substr);
        $this->assertNotSame($substr, $str);
        $this->assertEquals('Hello World', $substr->__toString());

        $str = new String_('Hello World');
        $this->assertEquals(' World', $str->substr(5)->__toString());

        $this->assertEquals(' W', $str->substr(5, 2)->__toString());

        $this->expectException(UnexpectedValueException::class);
        $str    = new String_();
        $substr = $str->substr(10);
    }

    public function test_strtolower()
    {
        $str        = new String_();
        $strtolower = $str->strtolower();
        $this->assertIsObject($strtolower);
        $this->assertInstanceOf(String_::class, $strtolower);
        $this->assertNotSame($strtolower, $str);
        $this->assertEquals('', $strtolower->__toString());

        $str = new String_('HELLO WORLD');
        $this->assertEquals('hello world', $str->strtolower()->__toString());

        $str = new String_('hello world');
        $this->assertEquals('hello world', $str->strtolower()->__toString());
    }

    public function test_strtoupper()
    {
        $str        = new String_();
        $strtoupper = $str->strtoupper();
        $this->assertIsObject($strtoupper);
        $this->assertInstanceOf(String_::class, $strtoupper);
        $this->assertNotSame($strtoupper, $str);
        $this->assertEquals('', $strtoupper->__toString());

        $str = new String_('hello world');
        $this->assertEquals('HELLO WORLD', $str->strtoupper()->__toString());

        $str = new String_('HELLO WORLD');
        $this->assertEquals('HELLO WORLD', $str->strtoupper()->__toString());
    }

    public function test_isEmpty()
    {
        $str     = new String_();
        $isEmpty = $str->isEmpty();
        $this->assertIsObject($isEmpty);
        $this->assertInstanceOf(Boolean_::class, $isEmpty);
        $this->assertTrue($isEmpty->isTrue());
        $this->assertFalse($isEmpty->isFalse());

        $str = new String_('h');
        $this->assertTrue($str->isEmpty()->isFalse());
        $this->assertFalse($str->isEmpty()->isTrue());
    }

    public function test_strlen()
    {
        $str    = new String_();
        $strlen = $str->strlen();
        $this->assertIsObject($strlen);
        $this->assertInstanceOf(Integer_::class, $strlen);
        $this->assertSame(0, $strlen->getNumber());

        $str = new String_('abcd');
        $this->assertSame(4, $str->strlen()->getNumber());
    }

    public function test_str_split()
    {
        $str       = new String_();
        $str_split = $str->str_split();
        $this->assertIsObject($str_split);
        $this->assertInstanceOf(Array_::class, $str_split);
        $this->assertSame([], $str_split->__toArray());

        $str = new String_('Hello');
        $this->assertSame(['H', 'e', 'l', 'l', 'o'], $str->str_split()->__toArray());

        $this->expectException(UnexpectedValueException::class);
        $str = new String_();
        $str->str_split(0);
    }

    public function test_hasSubject()
    {
        $str = new String_();
        $this->assertTrue(method_exists($str, '__toString'));
    }

    public function test_arrayaccess()
    {
        $str    = new String_();
        $str[0] = 'h';
        $this->assertSame('h', $str->__toString());
        $this->assertSame('h', $str[0]->__toString());
    }

    public function test_arrayaccess2()
    {
        $str    = new String_();
        $str[2] = 'H';
        $this->assertSame('  H', $str->__toString());
    }

    public function test_arrayaccess3()
    {
        $str    = new String_();
        $str[2] = 'Hello';
        $this->assertSame('  Hello', $str->__toString());
    }

    public function test_arrayaccess_error1()
    {
        $str = new String_();

        $error = false;
        try {
            $str['name'] = 'hello world';
        } catch (\Exception $e) {
            $error = true;
        }

        $this->assertTrue($error);
    }

    public function test_offsetGet_exception()
    {
        $this->expectException(LogicException::class);
        $str    = new String_();
        $str->offsetGet(0);
    }

    public function test_offsetUnset()
    {
        $str = new String_('a');
        $str->offsetUnset(0);
        $this->assertSame('', $str->__toString());
    }

    public function test_offsetUnset2()
    {
        $str = new String_('ab');
        $str->offsetUnset(0);
        $this->assertSame('b', $str->__toString());
    }

    public function test_offsetUnset_exception()
    {
        $this->expectException(LogicException::class);
        $str    = new String_();
        $str->offsetUnset(0);
    }
}
