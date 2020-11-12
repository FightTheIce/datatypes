<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Lists\IntegerList_;
use FightTheIce\Datatypes\Scalar\Integer_;

final class IntegerList_Test extends TestCase
{
    public function test_construct_basic()
    {
        $list = new IntegerList_();
        $this->assertSame([], $list->toArray());
    }

    public function test_construct_array()
    {
        $array = [1, 2, 6];
        $list  = new IntegerList_($array);
        $this->assertSame($array, $list->toArray());
    }

    public function test_construct_exception()
    {
        $this->expectException(\TypeError::class);
        $array = new stdClass();
        $list  = new IntegerList_($array);
    }

    public function test_construct_integerype()
    {
        $array = [1, 2, new Integer_(1), new Integer_(6)];
        $list  = new IntegerList_($array);
        $this->assertEquals($array, $list->toArray());
    }
}
