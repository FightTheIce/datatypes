<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Lists\FloatList_;
use FightTheIce\Datatypes\Scalar\Float_;

final class FloatList_Test extends TestCase
{
    public function test_construct_basic()
    {
        $list = new FloatList_();
        $this->assertSame([], $list->toArray());
    }

    public function test_construct_array()
    {
        $array = [1.5, 2.0, 6.77];
        $list  = new FloatList_($array);
        $this->assertSame($array, $list->toArray());
    }

    public function test_construct_exception()
    {
        $this->expectException(\TypeError::class);
        $array = new stdClass();
        $list  = new FloatList_($array);
    }

    public function test_construct_floattype()
    {
        $array = [1.77, 2.89, new Float_(1.7), new Float_(6.77)];
        $list  = new FloatList_($array);
        $this->assertEquals($array, $list->toArray());
    }
}
