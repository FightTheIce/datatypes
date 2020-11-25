<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Compound\Array_;
use FightTheIce\Datatypes\Core\Contracts\ArrayInterface;
use FightTheIce\Datatypes\Core\Contracts\CompoundInterface;
use FightTheIce\Datatypes\Core\Contracts\DatatypeInterface;
use FightTheIce\Datatypes\Scalar\Boolean_;
use Symfony\Component\Yaml\Yaml;
use Nette\Neon\Neon;

final class Array__Test extends TestCase
{
    public function test_meta()
    {
        $arr = new Array_();
        $this->assertInstanceOf(Array_::class, $arr);

        $this->assertInstanceOf(ArrayInterface::class, $arr);
        $this->assertInstanceOf(CompoundInterface::class, $arr);
        $this->assertInstanceOf(DatatypeInterface::class, $arr);
        $this->assertClassHasAttribute('items', Array_::class);

        $this->assertClassHasAttribute('macros', Array_::class);
    }

    public function test_getPrimitiveType()
    {
        $arr = new Array_();
        $this->assertEquals('array', $arr->getPrimitiveType());
    }

    public function test_getDatatypeCategory()
    {
        $arr = new Array_();
        $this->assertEquals('compound', $arr->getDatatypeCategory());
    }

    public function test_describe()
    {
        $arr = new Array_();
        $this->assertEquals('empty array', $arr->describe());

        $arr = new Array_(['1']);
        $this->assertEquals('indexed array', $arr->describe());

        $arr = new Array_(['name' => 'value']);
        $this->assertEquals('associative array', $arr->describe());

        $arr = new Array_([$this, 'test_describe']);
        $this->assertEquals('callable array', $arr->describe());
    }

    public function test__toArray()
    {
        //no data
        $arr = new Array_();
        $this->assertSame([], $arr->__toArray());

        //indexed
        $arr = new Array_(['1', '2', '3']);
        $this->assertSame(['1', '2', '3'], $arr->__toArray());

        //assoc
        $arr = new Array_(['name' => 'value']);
        $this->assertSame(['name' => 'value'], $arr->__toArray());

        //multidem
        $array = [
            1 => [
                '1a',
                '1b'
            ],
            2 => [
                '2a',
                '2b'
            ]
        ];
        $arr = new Array_($array);
        $this->assertSame($array, $arr->__toArray());
    }

    public function test_adddot(): void
    {
        $arr    = new Array_();
        $modArr = $arr->addDot('0', 'Hello World');
        $this->assertIsObject($modArr);
        $this->assertInstanceOf(Array_::class, $modArr);
        $this->assertSame(['0' => 'Hello World'], $modArr->__toArray());

        $arr = new Array_();
        $arr = $arr->addDot('0', 'Hello World');
        $this->assertSame(['0' => 'Hello World'], $arr->__toArray());

        $arr           = new Array_();
        $arr           = $arr->addDot('0', 'Hello World');
        $arr           = $arr->addDot('0.developers.id', 1);
        $expectedValue = [
            0 => [
                'developers' => [
                    'id' => 1
                ]
            ]
        ];

        $this->assertSame($expectedValue, $arr->__toArray());

        $arr           = $arr->addDot('0.developers.id', 2);
        $expectedValue = [
            0 => [
                'developers' => [
                    'id' => 2
                ]
            ]
        ];
        $this->assertSame($expectedValue, $arr->__toArray());
    }

    public function test_removeDot()
    {
        $arr = new Array_();
        $arr = $arr->addDot('0.developers.id', 1);
        $arr = $arr->addDot('0.developers.name', 'John');

        $expectedResult = [
            0 => [
                'developers' => [
                    'name' => 'John'
                ]
            ]
        ];

        $arr = $arr->removeDot('0.developers.id');
        $this->assertSame($expectedResult, $arr->__toArray());
    }

    public function test_getDot()
    {
        $arr = new Array_();
        $this->assertNull($arr->getDot('0'));

        $arr = $arr->addDot('0', 'Hello World');
        $this->assertSame('Hello World', $arr->getDot('0'));

        $arr = $arr->addDot('1.developers.id', 1);
        $this->assertSame(1, $arr->getDot('1.developers.id'));
    }

    public function test_isAssoc()
    {
        $arr   = new Array_();
        $assoc = $arr->isAssoc();
        $this->assertIsObject($assoc);
        $this->assertInstanceOf(Boolean_::class, $assoc);
        $this->assertFalse($arr->isAssoc()->isTrue());

        $arr[0] = 'hello';
        $arr[1] = 'goodbye';
        $this->assertFalse($arr->isAssoc()->isTrue());

        $arr['name'] = 'Boo';
        $this->assertTrue($arr->isAssoc()->isTrue());
    }

    public function test_setDot()
    {
        $arr = new Array_();
        $arr = $arr->setDot(0, 'Hello World');
        $arr = $arr->setDot('1.developers.id', 1);

        $expectedResult = [
            0   => 'Hello World',
            '1' => [
                'developers' => [
                    'id' => 1
                ]
            ]
        ];

        $this->assertSame($expectedResult, $arr->__toArray());
    }

    public function test_hasDot()
    {
        $arr    = new Array_();
        $hasDot = $arr->hasDot('0.developers');
        $this->assertIsObject($hasDot);
        $this->assertInstanceOf(Boolean_::class, $hasDot);
        $this->assertFalse($hasDot->isTrue());

        $arr = $arr->addDot('0.developers', 'Hello');
        $this->assertTrue($arr->hasDot('0.developers')->isTrue());
    }

    public function test_hasSubject()
    {
        $arr = new Array_();
        $this->assertTrue(method_exists($arr, '__toArray'));
    }

    public function test__toJson()
    {
        $data = [1, 2, 3];
        $arr  = new Array_($data);
        $this->assertSame(json_encode($data, JSON_PRETTY_PRINT), $arr->__toJson());
    }

    public function test__toYaml()
    {
        $data = [1, 2, 3];
        $arr  = new Array_($data);
        $this->assertSame(Yaml::dump($data), $arr->__toYaml());
    }

    public function test_toNeon()
    {
        $data = [1, 2, 3];
        $arr  = new Array_($data);
        $this->assertSame(Neon::encode($data, Neon::BLOCK), $arr->__toYaml());
    }
}
