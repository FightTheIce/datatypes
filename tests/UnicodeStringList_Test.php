<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Scalar\UnicodeString_;
use FightTheIce\Datatypes\Lists\UnicodeStringList_;

final class UnicodeStringList_Test extends TestCase
{
    public function test_construct_basic() {
        $list = new UnicodeStringList_();
        $this->assertSame(array(),$list->toArray());
    }

    public function test_construct_array() {
        $array = array('hello','world');
        $list = new UnicodeStringList_($array);
        $this->assertSame($array,$list->toArray());
    }

    public function test_construct_exception() {
        $this->expectException(\TypeError::class);
        $array = new stdClass();
        $list = new UnicodeStringList_($array);
    }

    public function test_construct_stringtype() {
        $array = array('hello world',new UnicodeString_('good bye world'));
        $list = new UnicodeStringList_($array);
        $this->assertEquals($array,$list->toArray());
    }
}