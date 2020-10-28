<?php

namespace FightTheIce\Tests\Datatypes;
use FightTheIce\Datatypes\Datatype\Array_;

class Array_Test extends \PHPUnit\Framework\TestCase {
    protected $array = null;

    public function setUp(): void{
        $this->array = new Array_();
    }

    public function test__construct() {
        # no arguments should result in a blank array
        $this->assertSame(array(), $this->array->toArray());

        # test with arguments
        $outcome = array(
            1,
            2,
            3,
        );
        $this->assertSame($outcome, $this->array->refresh($outcome)->toArray());
    }

    public function testgetType() {
        $this->assertEquals('array', $this->array->getType());
    }

    public function testgetValue() {
        $this->assertSame(array(), $this->array->getValue());
    }

    public function testoffsetExists() {
        $value = array(
            0 => 'test',
        );

        $this->assertTrue($this->array->refresh($value)->offsetExists(0));
    }

    public function testoffsetGet() {
        $value = array(
            0 => 'test',
        );

        $this->assertEquals($this->array->refresh($value)->offsetGet(0), 'test');
        $this->assertNull($this->array->offsetGet(1));
    }

    public function testoffsetSet() {
        $this->array->offsetSet(null, 'some string');
        $this->assertEquals(array(0 => 'some string'), $this->array->toArray());

        $this->array->offsetSet(0, 'new string');
        $this->assertEquals(array(0 => 'new string'), $this->array->toArray());
    }

    public function testoffsetunset() {
        $this->array->offsetUnset(1); //this should do nothing
        $this->assertEquals(array(), $this->array->toArray());

        $values = array(
            0 => 'some string',
        );
        $this->array->offsetUnset(0);
        $this->assertEquals(array(), $this->array->toArray());
    }

    public function testaddDot() {
        $obj = $this->array->addDot(0, 'some string');
        $this->assertEquals(array(0 => 'some string'), $this->array->toArray());
        $this->assertSame($obj, $this->array);

        $obj = $this->array->addDot('1.developer.name', 'William');
        $this->assertEquals(array(0 => 'some string', 1 => array('developer' => array('name' => 'William'))), $this->array->toArray());
        $this->assertSame($obj, $this->array);

        $obj = $this->array->addDot('1.developer.name', 'Frank');
        $this->assertEquals(array(0 => 'some string', 1 => array('developer' => array('name' => 'Frank'))), $this->array->toArray());
        $this->assertSame($obj, $this->array);

        //https://laravel.com/docs/8.x/helpers#method-array-add
        $obj = $this->array->refresh(['name' => 'Desk']);
        $this->assertSame($obj, $this->array);
        $this->array->addDot('price', 100);
        $this->assertEquals(array(
            'name'  => 'Desk',
            'price' => 100,
        ), $this->array->toArray());
    }

    public function testremoveDot() {
        $this->array->addDot('0.developer.name', 'William');
        $this->array->addDot('0.developer.id', 1);

        $this->assertEquals(array(
            0 => array(
                'developer' => array(
                    'name' => 'William',
                    'id'   => 1,
                ),
            ),
        ), $this->array->toArray());

        $obj = $this->array->removeDot('0.developer.name');
        $this->assertEquals(array(
            0 => array(
                'developer' => array(
                    'id' => 1,
                ),
            ),
        ), $this->array->toArray());
        $this->assertSame($obj, $this->array);

        $obj = $this->array->removeDot(0);
        $this->assertEquals(array(), $this->array->toArray());
        $this->assertSame($obj, $this->array);

        //https://laravel.com/docs/8.x/helpers#method-array-forget
        $value = array(
            'products' => array(
                'desk' => array(
                    'price' => 100,
                ),
            ),
        );
        $obj = $this->array->refresh($value);
        $this->assertSame($obj, $this->array);
        $obj = $this->array->removeDot('products.desk');
        $this->assertSame($obj, $this->array);
        $this->assertSame(array('products' => array()), $this->array->toArray());
    }

    public function testdivide() {
        $value = array(
            'firstname' => 'William',
            'lastname'  => 'Knauss',
            'gender'    => 'male',
            'hobbies'   => array(
                'art',
                'programming',
                'photography',
            ),
        );
        $obj = $this->array->refresh($value);
        $this->assertSame($obj, $this->array);
        $this->assertSame($value, $this->array->toArray());

        $obj = $this->array->divide();
        $this->assertSame($obj, $this->array);

        $this->assertSame(array(
            0 => array(
                'firstname',
                'lastname',
                'gender',
                'hobbies',
            ),
            1 => array(
                'William',
                'Knauss',
                'male',
                array(
                    'art',
                    'programming',
                    'photography',
                ),
            ),
        ), $this->array->toArray());

        //https://laravel.com/docs/8.x/helpers#method-array-divide
        $this->array->refresh(array('name' => 'desk'));
        $this->array->divide();
        $this->assertSame(array(
            0 => array('name'),
            1 => array('desk'),
        ), $this->array->toArray());
    }

    public function testdot() {
        $array = array(
            'names' => array(
                'Fred',
                'Frank',
                'Ferrie',
            ),
        );

        $obj = $this->array->refresh($array);
        $this->assertSame($obj, $this->array);

        $outcome = array(
            'names.0' => 'Fred',
            'names.1' => 'Frank',
            'names.2' => 'Ferrie',
        );
        $obj = $this->array->dot();
        $this->assertSame($obj, $this->array);
        $this->assertSame($outcome, $this->array->toArray());

        $values = ['products' => ['desk' => ['price' => 100]]];
        $this->array->refresh($values);
        $obj = $this->array->dot('-');
        $this->assertSame($obj, $this->array);
        $this->assertEquals(array('-products.desk.price' => 100), $this->array->toArray());

        //https://laravel.com/docs/8.x/helpers#method-array-dot
        $values = ['products' => ['desk' => ['price' => 100]]];
        $this->array->refresh($values);
        $obj = $this->array->dot();
        $this->assertSame($obj, $this->array);
        $this->assertEquals(array('products.desk.price' => 100), $this->array->toArray());
    }

    public function testexists() {
        $array = array(
            0 => 'some',
            1 => 'thing',
        );

        $obj = $this->array->refresh($array);
        $this->assertSame($obj, $this->array);

        $this->assertTrue($this->array->exists(0));
        $this->assertFalse($this->array->exists(2));

        //https://laravel.com/docs/8.x/helpers#method-array-exists
        $this->array->refresh(['name' => 'John Doe', 'age' => 17]);
        $this->assertTrue($this->array->exists('name'));
        $this->assertFalse($this->array->exists('salary'));
    }

    public function testgetDot() {
        $this->assertSame($this->array->getDot(0, 'does not exists'), 'does not exists');
        $this->array->addDot(0, 'some string');
        $this->assertSame($this->array->getDot(0), 'some string');
        $this->array->addDot('0.developer', 'William');
        $this->assertSame($this->array->getDot('0.developer'), 'William');

        //https://laravel.com/docs/8.x/helpers#method-array-get
        $array = ['products' => ['desk' => ['price' => 100]]];
        $this->array->refresh($array);

        $this->array->addDot('products.desk.price', 100);

        $price = $this->array->getDot('products.desk.price');
        $this->assertEquals($price, 100);
    }
}
