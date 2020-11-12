<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Lists\BooleanList_;
use FightTheIce\Datatypes\Scalar\Boolean_;

final class BooleanList_Test extends TestCase
{
    public function test_construct_basic()
    {
        $list = new BooleanList_();
        $this->assertSame([], $list->toArray());
    }

    public function test_construct_array()
    {
        $array = [true, false, false, true, true];
        $list  = new BooleanList_($array);
        $this->assertSame($array, $list->toArray());
    }

    public function test_construct_exception()
    {
        $this->expectException(\TypeError::class);
        $array = new stdClass();
        $list  = new BooleanList_($array);
    }

    public function test_construct_booleantype()
    {
        $array = [true, false, new Boolean_(true), new Boolean_(false)];
        $list  = new BooleanList_($array);
        $this->assertEquals($array, $list->toArray());
    }
}
