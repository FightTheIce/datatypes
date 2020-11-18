<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Compound\Callable_;
use FightTheIce\Datatypes\Core\Contracts\CallableInterface;
use FightTheIce\Datatypes\Core\Contracts\CompoundInterface;
use FightTheIce\Datatypes\Core\Contracts\DatatypeInterface;
use Brick\Math\BigInteger;
use FightTheIce\Datatypes\Scalar\String_;
use FightTheIce\Datatypes\Scalar\Boolean_;

final class Callable_Test extends TestCase
{
    public function test_meta()
    {
        $call = new Callable_();
        $this->assertInstanceOf(Callable_::class, $call);

        $this->assertInstanceOf(CallableInterface::class, $call);
        $this->assertInstanceOf(CompoundInterface::class, $call);
        $this->assertInstanceOf(DatatypeInterface::class, $call);
        $this->assertClassHasAttribute('call', Callable_::class);

        $this->assertClassHasAttribute('macros', Callable_::class);
    }

    public function test_getPrimitiveType()
    {
        $call = new Callable_();
        $this->assertEquals('callable', $call->getPrimitiveType());
    }

    public function test_getDatatypeCategory()
    {
        $call = new Callable_();
        $this->assertEquals('compound', $call->getDatatypeCategory());
    }

    public function test_describe()
    {
        $call = new Callable_();
        $this->assertEquals('callable string', $call->describe());

        $call = new Callable_('strtolower');
        $this->assertEquals('callable string', $call->describe());

        $call = new Callable_([$this, 'test_getDatatypeCategory']);
        $this->assertEquals('callable array', $call->describe());

        $call = new Callable_([BigInteger::class, 'of']);
        $this->assertEquals('callable array', $call->describe());

        $call = new Callable_(function () { echo 'Moo'; });
        $this->assertEquals('object of class Closure', $call->describe());
    }

    public function test___toCallable()
    {
        $call = new Callable_();
        $this->assertEquals('trim', $call->__toCallable());

        $call = new Callable_([$this, 'test_getDatatypeCategory']);
        $this->assertEquals([$this, 'test_getDatatypeCategory'], $call->__toCallable());

        $call = new Callable_([BigInteger::class, 'of']);
        $this->assertEquals([BigInteger::class, 'of'], $call->__toCallable());

        $closure = function () {
            echo 'Hello World';
        };
        $call = new Callable_($closure);
        $this->assertEquals($closure, $call->__toCallable());
    }

    public function test_resolveCallable()
    {
        $call = new Callable_();
        $res  = $call->resolveCallable('       hello   ');
        $this->assertIsString($res);
        $this->assertEquals('hello', $res);

        $str  = new String_('Hello World');
        $call = new Callable_([$str, 'strtoupper']);
        $res  = $call->resolveCallable();
        $this->assertIsObject($res);
        $this->assertInstanceOf(String_::class, $res);
        $this->assertEquals('HELLO WORLD', $res->__toString());

        $call = new Callable_([BigInteger::class, 'of']);
        $res  = $call->resolveCallable(16);
        $this->assertIsObject($res);
        $this->assertInstanceOf(BigInteger::class, $res);

        $func = function ($one, $two) {
            return new String_('Hello ' . $one . ' ' . $two);
        };

        $call = new Callable_($func);
        $res  = $call->resolveCallable('John', 'Doe');
        $this->assertIsObject($res);
        $this->assertInstanceOf(String_::class, $res);
        $this->assertSame('Hello John Doe', $res->__toString());
    }

    public function test_is_callable_string()
    {
        $call = new Callable_();
        $bool = $call->is_callable_string();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertFalse($bool->isFalse());

        $call = new Callable_('strtoupper');
        $this->assertTrue($call->is_callable_string()->isTrue());
        $this->assertFalse($call->is_callable_string()->isFalse());

        $call = new Callable_([$this, 'test_is_callable_string']);
        $this->assertFalse($call->is_callable_string()->isTrue());
    }

    public function test_is_callable_array()
    {
        $call = new Callable_([$this, 'test_is_callable_array']);
        $bool = $call->is_callable_array();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertFalse($bool->isFalse());
    }

    public function test_is_callable_closure()
    {
        $call = new Callable_(function () { echo 'Hello World ';});
        $bool = $call->is_callable_closure();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertFalse($bool->isFalse());
    }

    public function test_hasSubject()
    {
        $call = new Callable_();
        $this->assertTrue(method_exists($call, '__toCallable'));
    }
}
