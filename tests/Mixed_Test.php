<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Pseudo\Mixed_;
use FightTheIce\Datatypes\Compounds\Array_;
use FightTheIce\Datatypes\Scalar\String_;
use FightTheIce\Datatypes\Scalar\UnicodeString_;
use FightTheIce\Datatypes\Scalar\Boolean_;
use FightTheIce\Datatypes\Scalar\Float_;
use FightTheIce\Datatypes\Scalar\Integer_;
use FightTheIce\Datatypes\Compounds\Object_;
use FightTheIce\Datatypes\Special\Null_;

final class Mixed_Test extends TestCase
{
    public function test_array()
    {
        $data  = [];
        $mixed = new Mixed_($data);
        $this->assertSame($data, $mixed->getObject());

        $this->assertFalse($mixed->is_null()->IsTrue());
        $this->assertTrue($mixed->is_empty()->isTrue());
        $this->assertFalse($mixed->is_string()->isTrue());
        $this->assertFalse($mixed->is_unicode_string()->isTrue());
        $this->assertFalse($mixed->is_scalar()->isTrue());
        $this->assertFalse($mixed->is_float()->isTrue());
        $this->assertFalse($mixed->is_int()->isTrue());
        $this->assertFalse($mixed->is_bool()->isTrue());
        $this->assertFalse($mixed->is_object()->isTrue());
        $this->assertTrue($mixed->is_array()->isTrue());
        $this->assertFalse($mixed->is_numeric()->isTrue());
        $this->assertFalse($mixed->is_closure()->isTrue());
    }

    public function test_string()
    {
        $data  = '';
        $mixed = new Mixed_($data);
        $this->assertSame($data, $mixed->getObject());

        $this->assertFalse($mixed->is_null()->isTrue());
        $this->assertTrue($mixed->is_empty()->isTrue());
        $this->assertTrue($mixed->is_string()->isTrue());
        $this->assertFalse($mixed->is_unicode_string()->isTrue());
        $this->assertTrue($mixed->is_scalar()->isTrue());
        $this->assertFalse($mixed->is_float()->isTrue());
        $this->assertFalse($mixed->is_int()->isTrue());
        $this->assertFalse($mixed->is_bool()->isTrue());
        $this->assertFalse($mixed->is_object()->isTrue());
        $this->assertFalse($mixed->is_array()->isTrue());
        $this->assertFalse($mixed->is_numeric()->isTrue());
        $this->assertFalse($mixed->is_closure()->isTrue());
    }

    public function test_unicodestring()
    {
        $data  = 'नमस्ते दुनिया';
        $mixed = new Mixed_($data);
        $this->assertSame($data, $mixed->getObject());

        $this->assertFalse($mixed->is_null()->isTrue());
        $this->assertFalse($mixed->is_empty()->isTrue());
        $this->assertTrue($mixed->is_string()->isTrue());
        $this->assertTrue($mixed->is_unicode_string()->isTrue());
        $this->assertTrue($mixed->is_scalar()->isTrue());
        $this->assertFalse($mixed->is_float()->isTrue());
        $this->assertFalse($mixed->is_int()->isTrue());
        $this->assertFalse($mixed->is_bool()->isTrue());
        $this->assertFalse($mixed->is_object()->isTrue());
        $this->assertFalse($mixed->is_array()->isTrue());
        $this->assertFalse($mixed->is_numeric()->isTrue());
        $this->assertFalse($mixed->is_closure()->isTrue());
    }

    public function test_bool()
    {
        $data  = false;
        $mixed = new Mixed_($data);
        $this->assertSame($data, $mixed->getObject());

        $this->assertFalse($mixed->is_null()->isTrue());
        $this->assertTrue($mixed->is_empty()->isTrue());
        $this->assertFalse($mixed->is_string()->isTrue());
        $this->assertFalse($mixed->is_unicode_string()->isTrue());
        $this->assertTrue($mixed->is_scalar()->isTrue());
        $this->assertFalse($mixed->is_float()->isTrue());
        $this->assertFalse($mixed->is_int()->isTrue());
        $this->assertTrue($mixed->is_bool()->isTrue());
        $this->assertFalse($mixed->is_object()->isTrue());
        $this->assertFalse($mixed->is_array()->isTrue());
        $this->assertFalse($mixed->is_numeric()->isTrue());
        $this->assertFalse($mixed->is_closure()->isTrue());
    }

    public function test_float()
    {
        $data  = 1.77;
        $mixed = new Mixed_($data);
        $this->assertSame($data, $mixed->getObject());

        $this->assertFalse($mixed->is_null()->isTrue());
        $this->assertFalse($mixed->is_empty()->isTrue());
        $this->assertFalse($mixed->is_string()->isTrue());
        $this->assertFalse($mixed->is_unicode_string()->isTrue());
        $this->assertTrue($mixed->is_scalar()->isTrue());
        $this->assertTrue($mixed->is_float()->isTrue());
        $this->assertFalse($mixed->is_int()->isTrue());
        $this->assertFalse($mixed->is_bool()->isTrue());
        $this->assertFalse($mixed->is_object()->isTrue());
        $this->assertFalse($mixed->is_array()->isTrue());
        $this->assertTrue($mixed->is_numeric()->isTrue());
        $this->assertFalse($mixed->is_closure()->isTrue());
    }

    public function test_int()
    {
        $data  = 1;
        $mixed = new Mixed_($data);
        $this->assertSame($data, $mixed->getObject());

        $this->assertFalse($mixed->is_null()->isTrue());
        $this->assertFalse($mixed->is_empty()->isTrue());
        $this->assertFalse($mixed->is_string()->isTrue());
        $this->assertFalse($mixed->is_unicode_string()->isTrue());
        $this->assertTrue($mixed->is_scalar()->isTrue());
        $this->assertFalse($mixed->is_float()->isTrue());
        $this->assertTrue($mixed->is_int()->isTrue());
        $this->assertFalse($mixed->is_bool()->isTrue());
        $this->assertFalse($mixed->is_object()->isTrue());
        $this->assertFalse($mixed->is_array()->isTrue());
        $this->assertTrue($mixed->is_numeric()->isTrue());
        $this->assertFalse($mixed->is_closure()->isTrue());
    }

    public function test_object()
    {
        $data  = new stdClass();
        $mixed = new Mixed_($data);
        $this->assertSame($data, $mixed->getObject());

        $this->assertFalse($mixed->is_null()->isTrue());
        $this->assertFalse($mixed->is_empty()->isTrue());
        $this->assertFalse($mixed->is_string()->isTrue());
        $this->assertFalse($mixed->is_unicode_string()->isTrue());
        $this->assertFalse($mixed->is_scalar()->isTrue());
        $this->assertFalse($mixed->is_float()->isTrue());
        $this->assertFalse($mixed->is_int()->isTrue());
        $this->assertFalse($mixed->is_bool()->isTrue());
        $this->assertTrue($mixed->is_object()->isTrue());
        $this->assertFalse($mixed->is_array()->isTrue());
        $this->assertFalse($mixed->is_numeric()->isTrue());
        $this->assertFalse($mixed->is_closure()->isTrue());
    }

    public function test_null()
    {
        $data  = null;
        $mixed = new Mixed_($data);
        $this->assertSame($data, $mixed->getObject());

        $this->assertTrue($mixed->is_null()->isTrue());
        $this->assertTrue($mixed->is_empty()->isTrue());
        $this->assertFalse($mixed->is_string()->isTrue());
        $this->assertFalse($mixed->is_unicode_string()->isTrue());
        $this->assertFalse($mixed->is_scalar()->isTrue());
        $this->assertFalse($mixed->is_float()->isTrue());
        $this->assertFalse($mixed->is_int()->isTrue());
        $this->assertFalse($mixed->is_bool()->isTrue());
        $this->assertFalse($mixed->is_object()->isTrue());
        $this->assertFalse($mixed->is_array()->isTrue());
        $this->assertFalse($mixed->is_numeric()->isTrue());
        $this->assertFalse($mixed->is_closure()->isTrue());
    }

    public function test_closure()
    {
        $data = function () {
            echo 'Moo';
        };

        $mixed = new Mixed_($data);
        $this->assertSame($data, $mixed->getObject());

        $this->assertFalse($mixed->is_null()->isTrue());
        $this->assertFalse($mixed->is_empty()->isTrue());
        $this->assertFalse($mixed->is_string()->isTrue());
        $this->assertFalse($mixed->is_unicode_string()->isTrue());
        $this->assertFalse($mixed->is_scalar()->isTrue());
        $this->assertFalse($mixed->is_float()->isTrue());
        $this->assertFalse($mixed->is_int()->isTrue());
        $this->assertFalse($mixed->is_bool()->isTrue());
        $this->assertTrue($mixed->is_object()->isTrue());
        $this->assertFalse($mixed->is_array()->isTrue());
        $this->assertFalse($mixed->is_numeric()->isTrue());
        $this->assertTrue($mixed->is_closure()->isTrue());
    }

    public function test_getDataTypeClass()
    {
        $mixed = new Mixed_([]);
        $this->assertInstanceOf(Array_::class, $mixed->getDatatypeClass());

        $mixed = new Mixed_('hello world');
        $this->assertInstanceOf(String_::class, $mixed->getDatatypeClass());

        $mixed = new Mixed_('नमस्ते दुनिया');
        $this->assertInstanceOf(UnicodeString_::class, $mixed->getDatatypeClass());

        $mixed = new Mixed_(false);
        $this->assertInstanceOf(Boolean_::class, $mixed->getDatatypeClass());

        $mixed = new Mixed_(true);
        $this->assertInstanceOf(Boolean_::class, $mixed->getDatatypeClass());

        $mixed = new Mixed_(1.7);
        $this->assertInstanceOf(Float_::class, $mixed->getDatatypeClass());

        $mixed = new Mixed_(1);
        $this->assertInstanceOf(Integer_::class, $mixed->getDatatypeClass());

        $mixed = new Mixed_($this);
        $this->assertInstanceOf(Object_::class, $mixed->getDatatypeClass());

        $mixed = new Mixed_(null);
        $this->assertInstanceOf(Null_::class, $mixed->getDatatypeClass());
    }

    public function test_getType()
    {
        $mixed = new Mixed_([]);
        $this->assertEquals('array', $mixed->gettype());

        $mixed = new Mixed_('hello world');
        $this->assertEquals('string', $mixed->gettype());

        $mixed = new Mixed_('नमस्ते दुनिया');
        $this->assertEquals('string', $mixed->gettype());

        $mixed = new Mixed_(false);
        $this->assertEquals('boolean', $mixed->gettype());

        $mixed = new Mixed_(true);
        $this->assertEquals('boolean', $mixed->gettype());

        $mixed = new Mixed_(1.7);
        $this->assertEquals('float', $mixed->gettype());

        $mixed = new Mixed_(1);
        $this->assertEquals('integer', $mixed->gettype());

        $mixed = new Mixed_($this);
        $this->assertEquals('object', $mixed->gettype());

        $mixed = new Mixed_(null);
        $this->assertEquals('null', $mixed->gettype());
    }

    public function test_resolve()
    {
        $mixed = new Mixed_([]);
        $this->assertInstanceOf(Array_::class, $mixed->resolve());

        $mixed = new Mixed_('hello world');
        $this->assertInstanceOf(String_::class, $mixed->resolve());

        $mixed = new Mixed_('नमस्ते दुनिया');
        $this->assertInstanceOf(UnicodeString_::class, $mixed->resolve());

        $mixed = new Mixed_(false);
        $this->assertInstanceOf(Boolean_::class, $mixed->resolve());

        $mixed = new Mixed_(true);
        $this->assertInstanceOf(Boolean_::class, $mixed->resolve());

        $mixed = new Mixed_(1.7);
        $this->assertInstanceOf(Float_::class, $mixed->resolve());

        $mixed = new Mixed_(1);
        $this->assertInstanceOf(Integer_::class, $mixed->resolve());

        $mixed = new Mixed_($this);
        $this->assertInstanceOf(Object_::class, $mixed->resolve());

        $mixed = new Mixed_(null);
        $this->assertInstanceOf(Null_::class, $mixed->resolve());
    }

    public function test_resource()
    {
        $resource = @\fopen('php://memory', 'rb');
        $mixed    = new Mixed_($resource);
        $this->assertSame($resource, $mixed->resolve()->getValue());
    }

    public function test_mixed_from_datatype()
    {
        $str   = new String_('Hello World');
        $mixed = new Mixed_($str);
        $this->assertInstanceOf(String_::class, $mixed->resolve());
    }

    public function test_describe()
    {
        $mixed = new Mixed_([]);
        $this->assertEquals('empty array', $mixed->describe());

        $mixed = new Mixed_([1, 2, 3]);
        $this->assertEquals('indexed array', $mixed->describe());

        $mixed = new Mixed_(['name' => 'William']);
        $this->assertEquals('associative array', $mixed->describe());

        $mixed = new Mixed_([$this, 'test_describe']);
        $this->assertEquals('callable array', $mixed->describe());

        $mixed = new Mixed_($this);
        $this->assertEquals('object of class Mixed_Test', $mixed->describe());

        $resource = @\fopen('php://memory', 'rb');
        $mixed    = new Mixed_($resource);
        $this->assertEquals('resource of type stream', $mixed->describe());

        $mixed = new Mixed_(1);
        $this->assertEquals('positive integer', $mixed->describe());

        $mixed = new Mixed_(+1);
        $this->assertEquals('positive integer', $mixed->describe());

        $mixed = new Mixed_(-1);
        $this->assertEquals('negative integer', $mixed->describe());

        $mixed = new Mixed_(0);
        $this->assertEquals('zero integer', $mixed->describe());

        $mixed = new Mixed_(-1.0);
        $this->assertEquals('negative float', $mixed->describe());

        $mixed = new Mixed_(1.0);
        $this->assertEquals('positive float', $mixed->describe());

        $mixed = new Mixed_(0.0);
        $this->assertEquals('zero float', $mixed->describe());

        $mixed = new Mixed_('');
        $this->assertEquals('empty string', $mixed->describe());

        $mixed = new Mixed_('strtolower');
        $this->assertEquals('callable string', $mixed->describe());

        $mixed = new Mixed_('12345');
        $this->assertEquals('numeric string', $mixed->describe());

        $mixed = new Mixed_('hello world');
        $this->assertEquals('string', $mixed->describe());

        $mixed = new Mixed_(true);
        $this->assertEquals('boolean true', $mixed->describe());

        $mixed = new Mixed_(false);
        $this->assertEquals('boolean false', $mixed->describe());
    }
}
