<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Lists\ListList_;
use FightTheIce\Datatypes\Lists\BooleanList_;
use FightTheIce\Datatypes\Lists\FloatList_;

final class ListList_Test extends TestCase
{
    public function test_construct_basic() {
        $list = new ListList_();
        $this->assertSame(array(),$list->toArray());
    }

    public function test_construct_array() {
        $array = array(new BooleanList_(),new FloatList_());
        $list = new ListList_($array);
        $this->assertSame($array,$list->toArray());
    }

        public function test_construct_exception() {
        $this->expectException(\TypeError::class);
        $array = new stdClass();
        $list = new ListList_($array);
    }
}