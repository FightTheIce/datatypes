<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use Nette\Neon\Neon;

final class Array_Test extends TestCase
{
    public function test_getvalue(): void
    {
        $arr = new \FightTheIce\Datatypes\Compounds\Array_();
        $this->assertSame([], $arr->getValue());

        $array = [
            [
                1
            ],
            [
                2
            ],
            [
                3
            ]
        ];

        $arr = new \FightTheIce\Datatypes\Compounds\Array_($array);
        $this->assertSame($array, $arr->getValue());
    }

    public function test_adddot(): void
    {
        $arr = new \FightTheIce\Datatypes\Compounds\Array_();
        $arr = $arr->addDot('0', 'Hello World');
        $this->assertSame(['0' => 'Hello World'], $arr->getValue());

        $arr           = new \FightTheIce\Datatypes\Compounds\Array_();
        $arr           = $arr->addDot('0', 'Hello World');
        $arr           = $arr->addDot('0.developers.id', 1);
        $expectedValue = [
            0 => [
                'developers' => [
                    'id' => 1
                ]
            ]
        ];

        $this->assertSame($expectedValue, $arr->getValue());

        $arr           = $arr->addDot('0.developers.id', 2);
        $expectedValue = [
            0 => [
                'developers' => [
                    'id' => 2
                ]
            ]
        ];
        $this->assertSame($expectedValue, $arr->getValue());
    }

    public function test_removeDot()
    {
        $arr = new \FightTheIce\Datatypes\Compounds\Array_();
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
        $this->assertSame($expectedResult, $arr->getValue());
    }

    public function test_getDot()
    {
        $arr = new \FightTheIce\Datatypes\Compounds\Array_();
        $this->assertNull($arr->getDot('0'));

        $arr = $arr->addDot('0', 'Hello World');
        $this->assertSame('Hello World', $arr->getDot('0'));

        $arr = $arr->addDot('1.developers.id', 1);
        $this->assertSame(1, $arr->getDot('1.developers.id'));
    }

    public function test_isAssoc()
    {
        $arr = new \FightTheIce\Datatypes\Compounds\Array_();
        $this->assertFalse($arr->isAssoc());

        $arr[0] = 'hello';
        $arr[1] = 'goodbye';
        $this->assertFalse($arr->isAssoc());

        $arr['name'] = 'Boo';
        $this->assertTrue($arr->isAssoc());
    }

    public function test_setDot()
    {
        $arr = new \FightTheIce\Datatypes\Compounds\Array_();
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

        $this->assertSame($expectedResult, $arr->getValue());
    }

    public function test_hasDot()
    {
        $arr = new \FightTheIce\Datatypes\Compounds\Array_();
        $this->assertFalse($arr->hasDot('0.developers'));

        $arr = $arr->addDot('0.developers', 'Hello');
        $this->assertTrue($arr->hasDot('0.developers'));
    }

    public function test_toYaml()
    {
        $data = [
            1,
            2,
            3
        ];

        $arr = new \FightTheIce\Datatypes\Compounds\Array_($data);
        $this->assertSame(Yaml::dump($data, 3), $arr->toYaml());
    }

    public function test_toNeon()
    {
        $data = [
            1,
            2,
            3
        ];

        $arr = new \FightTheIce\Datatypes\Compounds\Array_($data);
        $this->assertSame(Neon::encode($data, Neon::BLOCK), $arr->toNeon());
    }
}
