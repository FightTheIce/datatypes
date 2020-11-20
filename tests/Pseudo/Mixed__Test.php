<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Pseudo\Mixed_;
use FightTheIce\Datatypes\Core\Contracts\MixedInterface;
use FightTheIce\Datatypes\Core\Contracts\PseudoInterface;
use FightTheIce\Datatypes\Core\Contracts\DatatypeInterface;
use FightTheIce\Datatypes\Scalar\Boolean_;
use FightTheIce\Datatypes\Compound\Callable_;
use FightTheIce\Datatypes\Compound\Array_;
use FightTheIce\Datatypes\Compound\Object_;
use FightTheIce\Datatypes\Scalar\Float_;
use FightTheIce\Datatypes\Scalar\Integer_;
use FightTheIce\Datatypes\Special\Null_;
use FightTheIce\Datatypes\Special\Resource_;
use FightTheIce\Datatypes\Scalar\String_;
use FightTheIce\Datatypes\Scalar\UnicodeString_;
use FightTheIce\Datatypes\Pseudo\Void_;

final class Mixed_Test extends TestCase
{
    public function test_meta()
    {
        $mixed = new Mixed_();
        $this->assertInstanceOf(Mixed_::class, $mixed);

        $this->assertInstanceOf(MixedInterface::class, $mixed);
        $this->assertInstanceOf(PseudoInterface::class, $mixed);
        $this->assertInstanceOf(DatatypeInterface::class, $mixed);

        $this->assertClassHasAttribute('macros', Mixed_::class);
        $this->assertClassHasAttribute('mixed', Mixed_::class);
    }

    public function test_getPrimitiveType()
    {
        $mixed = new Mixed_();
        $this->assertEquals('mixed', $mixed->getPrimitiveType());
    }

    public function test_getDatatypeCategory()
    {
        $mixed = new Mixed_();
        $this->assertEquals('pseudo', $mixed->getDatatypeCategory());
    }

    public function test_construct_callable()
    {
        $call  = 'strtolower';
        $mixed = new Mixed_($call);
        $this->assertIsString($mixed->__toMixed());
        $resolve = $mixed->resolve();
        $this->assertIsObject($resolve);
        $this->assertInstanceOf(Callable_::class, $resolve);
        $bool = $mixed->isCallable();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertSame('callable string', $mixed->describe());
        $bool = $mixed->isCompoundType();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertFalse($bool->isFalse());

        $call  = [$this, 'test_construct_callable'];
        $mixed = new Mixed_($call);
        $this->assertTrue($mixed->isCallable()->isTrue());
        $this->assertSame('callable array', $mixed->describe());
        $bool = $mixed->isCompoundType();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertFalse($bool->isFalse());
    }

    public function test_construct_array()
    {
        $call  = [1, 2, 3];
        $mixed = new Mixed_($call);
        $this->assertIsArray($mixed->__toMixed());
        $resolve = $mixed->resolve();
        $this->assertIsObject($resolve);
        $this->assertInstanceOf(Array_::class, $resolve);
        $bool = $mixed->isArray();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertSame('indexed array', $mixed->describe());
        $bool = $mixed->isCompoundType();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertFalse($bool->isFalse());
    }

    public function test_construct_object()
    {
        $call  = new stdClass();
        $mixed = new Mixed_($call);
        $this->assertIsObject($mixed->__toMixed());
        $resolve = $mixed->resolve();
        $this->assertIsObject($resolve);
        $this->assertInstanceOf(Object_::class, $resolve);
        $bool = $mixed->isObject();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertSame('object of class stdClass', $mixed->describe());
        $bool = $mixed->isCompoundType();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertFalse($bool->isFalse());
    }

    public function test_construct_bool()
    {
        $call  = false;
        $mixed = new Mixed_($call);
        $this->assertIsBool($mixed->__toMixed());
        $resolve = $mixed->resolve();
        $this->assertIsObject($resolve);
        $this->assertInstanceOf(Boolean_::class, $resolve);
        $bool = $mixed->isBoolean();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertSame('boolean false', $mixed->describe());
        $bool = $mixed->isScalarType();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());

        $call  = true;
        $mixed = new Mixed_($call);
        $this->assertIsBool($mixed->__toMixed());
        $resolve = $mixed->resolve();
        $this->assertIsObject($resolve);
        $this->assertInstanceOf(Boolean_::class, $resolve);
        $bool = $mixed->isBoolean();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertSame('boolean true', $mixed->describe());
        $bool = $mixed->isScalarType();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
    }

    public function test_construct_float()
    {
        $call  = 9.123;
        $mixed = new Mixed_($call);
        $this->assertIsFloat($mixed->__toMixed());
        $resolve = $mixed->resolve();
        $this->assertIsObject($resolve);
        $this->assertInstanceOf(Float_::class, $resolve);
        $bool = $mixed->isFloat();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertSame('positive float', $mixed->describe());
        $bool = $mixed->isScalarType();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $bool = $mixed->isNumeric();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());

        $call  = -9.123;
        $mixed = new Mixed_($call);
        $this->assertIsFloat($mixed->__toMixed());
        $resolve = $mixed->resolve();
        $this->assertIsObject($resolve);
        $this->assertInstanceOf(Float_::class, $resolve);
        $bool = $mixed->isFloat();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertSame('negative float', $mixed->describe());
        $bool = $mixed->isScalarType();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $bool = $mixed->isNumeric();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
    }

    public function test_construct_int()
    {
        $call  = 9;
        $mixed = new Mixed_($call);
        $this->assertIsInt($mixed->__toMixed());
        $resolve = $mixed->resolve();
        $this->assertIsObject($resolve);
        $this->assertInstanceOf(Integer_::class, $resolve);
        $bool = $mixed->isInteger();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertSame('positive integer', $mixed->describe());
        $bool = $mixed->isScalarType();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());

        $call  = -9;
        $mixed = new Mixed_($call);
        $this->assertIsInt($mixed->__toMixed());
        $resolve = $mixed->resolve();
        $this->assertIsObject($resolve);
        $this->assertInstanceOf(Integer_::class, $resolve);
        $bool = $mixed->isInteger();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertSame('negative integer', $mixed->describe());
        $bool = $mixed->isScalarType();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
    }

    public function test_construct_null()
    {
        $call  = null;
        $mixed = new Mixed_($call);
        $this->assertNull($mixed->__toMixed());
        $resolve = $mixed->resolve();
        $this->assertIsObject($resolve);
        $this->assertInstanceOf(Null_::class, $resolve);
        $bool = $mixed->isNull();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertSame('null value', $mixed->describe());
        $bool = $mixed->isSpecialType();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertFalse($bool->isFalse());
    }

    public function test_construct_resource()
    {
        $call  = @\fopen('php://memory', 'rb');
        $mixed = new Mixed_($call);
        $this->assertIsResource($mixed->__toMixed());
        $resolve = $mixed->resolve();
        $this->assertIsObject($resolve);
        $this->assertInstanceOf(Resource_::class, $resolve);
        $bool = $mixed->isResource();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertSame('resource of type stream', $mixed->describe());
        $bool = $mixed->isSpecialType();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertFalse($bool->isFalse());
    }

    public function test_construct_string()
    {
        $call  = 'hello world';
        $mixed = new Mixed_($call);
        $this->assertIsString($mixed->__toMixed());
        $resolve = $mixed->resolve();
        $this->assertIsObject($resolve);
        $this->assertInstanceOf(String_::class, $resolve);
        $bool = $mixed->isString();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertSame('string', $mixed->describe());
        $bool = $mixed->isStandardString();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $bool = $mixed->isScalarType();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());

        $call  = '한국어';
        $mixed = new Mixed_($call);
        $this->assertIsString($mixed->__toMixed());
        $resolve = $mixed->resolve();
        $this->assertIsObject($resolve);
        $this->assertInstanceOf(UnicodeString_::class, $resolve);
        $bool = $mixed->isString();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertSame('string', $mixed->describe());
        $bool = $mixed->isUnicodeString();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $bool = $mixed->isScalarType();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
    }

    public function test_isEmpty()
    {
        $call  = '';
        $mixed = new Mixed_($call);
        $bool  = $mixed->isEmpty();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertFalse($bool->isFalse());

        $call  = [];
        $mixed = new Mixed_($call);
        $bool  = $mixed->isEmpty();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertFalse($bool->isFalse());
    }

    public function test_closure()
    {
        $func = function () {
            echo 'Hello World';
        };
        $mixed=  new Mixed_($func);
        $bool = $mixed->isClosure();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertFalse($bool->isFalse());

        $bool = $mixed->isObject();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertFalse($bool->isTrue());
        $this->assertTrue($bool->isFalse());
    }

    public function test_construct_void()
    {
        $void  = new Void_();
        $mixed = new Mixed_($void);
        $this->assertInstanceOf(Void_::class, $mixed->resolve());
        $bool = $mixed->isVoid();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
    }

    public function test_construct_iterable()
    {
        $call  = collect(1, 2, 3);
        $mixed = new Mixed_($call);
        $bool  = $mixed->isIterable();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
        $this->assertFalse($bool->isFalse());
    }
}
