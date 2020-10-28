<?php

namespace FightTheIce\Tests\Datatypes;
use FightTheIce\Datatypes\Datatype\Array_;

class Array_Test extends \PHPUnit\Framework\TestCase {
    protected $array = null;

    public function setUp(): void{
        $this->array = new Array_();
    }

    public function testClassData() {
        $this->assertInstanceOf(\FightTheIce\Datatypes\Datatype\Array_::class, $this->array);

        $this->assertInstanceOf(\FightTheIce\Datatypes\Core\Interfaces\DatatypeInterface::class, $this->array);
        $this->assertInstanceOf(\ArrayAccess::class, $this->array);
        $this->assertInstanceOf(\IteratorAggregate::class, $this->array);

        $this->assertHasTrait(\Illuminate\Support\Traits\ForwardsCalls::class, $this->array);
        $this->assertHasTrait(\Illuminate\Support\Traits\Macroable::class, $this->array);

        $this->assertClassHasProperty('collection', $this->array);
        $this->assertClassHasProperty('arr', $this->array);
    }

    public function test__construct() {
        //make sure our class has the __construct method
        $this->assertClassHasMethod('__construct', $this->array);

        //make sure __construct takes a parameter
        $this->assertMethodHasParameter('arr', '__construct', $this->array);
        $this->assertMethodParameterIsOptional('arr', '__construct', $this->array);

        //lets test it with no parameters
        $this->assertInstanceOf(\FightTheIce\Datatypes\Datatype\Array_::class, new Array_());

        //lets test it with an empty array
        $this->assertInstanceOf(\FightTheIce\Datatypes\Datatype\Array_::class, new Array_(array()));

        //lets test it with an stdClass
        $this->expectException(\TypeError::class);
        $this->assertInstanceOf(\ArrayAccess::class, new Array_(new \StdClass()));
    }

    public function test_getType() {
        $this->assertEquals($this->array->getType(), 'array');
    }

    public function test_getValue() {
        $this->assertEquals(array(), $this->array->getValue());
    }

    protected function assertHasTrait($trait, $obj) {
        //this requires illuminate/support
        $objectHasTraits = class_uses_recursive($obj);
        $objectTraits    = array_values($objectHasTraits);

        $this->assertTrue(in_array($trait, $objectTraits));
    }

    protected function assertClassHasProperty(string $name, $obj) {
        if (is_object($obj)) {
            $obj = get_class($obj);
        }

        $this->assertClassHasAttribute($name, $obj);
    }

    protected function assertClassHasMethod(string $methodName, $obj) {
        $this->assertTrue(method_exists($obj, $methodName), 'The object does not have a method named: ' . $methodName);
    }

    protected function assertMethodHasParameter(string $parameterName, string $methodName, $obj) {
        $classReflection = new \ReflectionClass($obj);
        $methods         = $classReflection->getMethods();

        $methodNames = array();
        foreach ($methods as $method) {
            $methodNames[] = $method->getName();
        }

        $method = $classReflection->getMethod($methodName);
        if (!$method) {
            $this->assertTrue(false, 'Object: ' . $classReflection->getName() . ' does not have a method named: ' . $methodName);
            return;
        }
        $parameterNames = array();
        foreach ($method->getParameters() as $parameter) {
            $parameterNames[] = $parameter->getName();
        }

        $this->assertTrue(in_array($parameterName, $parameterNames), 'Object: ' . $classReflection->getName() . ' does not have a parameter named: ' . $parameterName);
    }

    protected function assertMethodParameterIsOptional(string $parameterName, string $methodName, $obj) {
        $classReflection = new \ReflectionClass($obj);
        $methods         = $classReflection->getMethods();

        $methodNames = array();
        foreach ($methods as $method) {
            $methodNames[] = $method->getName();
        }

        if (!in_array($methodName, $methodNames)) {
            $this->assertTrue(false, 'Object: ' . $classReflection->getName() . ' does not have a method by the name of: ' . $methodName);
            return;
        }

        $method     = $classReflection->getMethod($methodName);
        $parameters = $method->getParameters();
        if (!$parameters) {
            $this->assertTrue(false, 'Object: ' . $classReflection->getName() . ' method: ' . $methodName . ' does not have a parameter with the name: ' . $parameterName);
            return;
        }

        foreach ($parameters as $param) {
            if ($param->getName() == $parameterName) {
                $this->assertTrue($param->isOptional());
                return;
            }
        }

        $this->assertTrue(false, 'You should have never made it this far');
    }
}
