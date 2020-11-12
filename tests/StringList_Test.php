<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Scalar\String_;
use FightTheIce\Datatypes\Lists\StringList_;

final class StringList_Test extends TestCase
{
    public function test_construct_basic() {
        $list = new StringList_();
        $this->assertSame(array(),$list->toArray());
    }

    public function test_construct_array() {
        $array = array('hello','world');
        $list = new StringList_($array);
        $this->assertSame($array,$list->toArray());
    }

    public function test_construct_exception() {
        $this->expectException(\TypeError::class);
        $array = new stdClass();
        $list = new StringList_($array);
    }

    public function test_construct_stringtype() {
        $array = array('hello world',new String_('good bye world'));
        $list = new StringList_($array);
        $this->assertEquals($array,$list->toArray());
    }
}