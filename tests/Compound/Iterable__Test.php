<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Compound\Iterable_;
use FightTheIce\Datatypes\Core\Contracts\IterableInterface;
use FightTheIce\Datatypes\Core\Contracts\CompoundInterface;
use FightTheIce\Datatypes\Core\Contracts\DatatypeInterface;

final class Iterable_Test extends TestCase
{
    public function test_meta()
    {
        $it = new Iterable_();
        $this->assertInstanceOf(Iterable_::class, $it);

        $this->assertInstanceOf(IterableInterface::class, $it);
        $this->assertInstanceOf(CompoundInterface::class, $it);
        $this->assertInstanceOf(DatatypeInterface::class, $it);
        $this->assertClassHasAttribute('iterate', Iterable_::class);

        $this->assertClassHasAttribute('macros', Iterable_::class);
    }

    public function test_getPrimitiveType()
    {
        $it = new Iterable_();
        $this->assertEquals('iterable', $it->getPrimitiveType());
    }

    public function test_getDatatypeCategory()
    {
        $it = new Iterable_();
        $this->assertEquals('compound', $it->getDatatypeCategory());
    }

    public function test_describe()
    {
        $it = new Iterable_();
        $this->assertEquals('empty array', $it->describe());

        $it = new Iterable_(collect(1, 2, 3));
        $this->assertEquals('object of class Illuminate\Support\Collection', $it->describe());
    }

    public function test__toIterable()
    {
        $arr = [1, 2, 3];
        $it  = new Iterable_($arr);
        $this->assertSame($arr, $it->__toIterable());

        $collect = collect(2, 3, 4);
        $it      = new Iterable_($collect);
        $this->assertSame($collect, $it->__toIterable());
    }

    public function test_hasSubject()
    {
        $call = new Iterable_();
        $this->assertTrue(method_exists($call, '__toIterable'));
    }
}
