<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Scalar\Integer_;
use FightTheIce\Datatypes\Scalar\Float_;
use FightTheIce\Datatypes\Pseudo\Number_;
use FightTheIce\Datatypes\Lists\NumberList_;

final class NumberList_Test extends TestCase
{
    public function test_construct_basic()
    {
        $list = new NumberList_();
        $this->assertSame([], $list->toArray());
    }

    public function test_construct_array()
    {
        $array = [1, 2.66];
        $list  = new NumberList_($array);
        $this->assertSame($array, $list->toArray());
    }

    public function test_construct_exception()
    {
        $this->expectException(\TypeError::class);
        $array = new stdClass();
        $list  = new NumberList_($array);
    }

    public function test_construct_integertype()
    {
        $array = [new Integer_(1)];
        $list  = new NumberList_($array);
        $this->assertEquals($array, $list->toArray());
    }

    public function test_construct_floattype()
    {
        $array = [new Float_(1.55)];
        $list  = new NumberList_($array);
        $this->assertEquals($array, $list->toArray());
    }

    public function test_construct_numbertype_float()
    {
        $array = [new Number_(1.55)];
        $list  = new NumberList_($array);
        $this->assertEquals($array, $list->toArray());
    }

    public function test_construct_numbertype_integer()
    {
        $array = [new Number_(15)];
        $list  = new NumberList_($array);
        $this->assertEquals($array, $list->toArray());
    }

    public function test_construct_allnumbertypes()
    {
        $array = [1, 2.66, new Integer_(1), new Float_(1.77), new Number_(1), new Number_(7.88)];
        $list  = new NumberList_($array);
        $this->assertEquals($array, $list->toArray());
    }
}
