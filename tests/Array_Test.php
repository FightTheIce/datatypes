<?php

namespace FightTheIce\Tests\Datatypes;
use FightTheIce\Datatypes\Datatype\Array_;

class Array_Test extends \PHPUnit\Framework\TestCase {
    protected $array = null;

    public function setUp(): void{
        $this->array = new Array_();
    }

    public function test__construct_noarguments() {
        $this->assertSame($this->array->toArray(), array());
    }

    public function test__construct_withdefaultarray() {
        $value = array(
            0 => 'zero',
        );

        $this->assertSame($this->array->refresh($value)->toArray(), $value);
    }

    public function testgetType() {
        $this->assertEquals($this->array->getType(), 'array');
    }

    public function testgetValue() {
        $value = array(
            0 => 'zero',
        );

        $this->assertSame($this->array->refresh($value)->getValue(), $value);
    }

    public function testaddDot_basickey() {
        $test = array(
            0 => 'zero',
        );

        $this->array->addDot(0, 'zero');

        $this->assertSame($this->array->toArray(), $test);
    }

    public function testaddDot_basickey_overwrite() {
        $test = array(
            0 => 'one',
        );

        $this->array->addDot(0, 'zero');
        $this->array->addDot(0, 'one');

        $this->assertSame($this->array->toArray(), $test);
    }

    public function testaddDot_advanced() {
        $test = array(
            0 => array(
                'developer' => 'William',
            ),
        );

        $this->array->addDot('0.developer', 'William');

        $this->assertSame($this->array->toArray(), $test);
    }

    public function testremoveDot_basickey() {
        $outcome = array(
            0 => 'some string',
        );

        $this->array->addDot(0, 'some string');
        $this->array->addDot(1, 'other string');

        $this->assertEquals($this->array->toArray(), array(
            0 => 'some string',
            1 => 'other string',
        ));

        $this->array->removeDot(1);

        $this->assertEquals($this->array->toArray(), $outcome);
    }

    public function testremoveDot_advanced() {
        $outcome = array(
            0 => array(
                'developer' => 'William',
            ),
            1 => array(
            ),
        );

        $this->array->addDot(0, array('developer' => 'William'));
        $this->array->addDot(1, array('developer' => 'William'));

        $this->assertEquals($this->array->toArray(), array(
            0 => array(
                'developer' => 'William',
            ),
            1 => array(
                'developer' => 'William',
            ),
        ));

        $this->array->removeDot('1.developer');

        $this->assertEquals($this->array->toArray(), $outcome);
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

        $keys = array(
            'firstname',
            'lastname',
            'gender',
            'hobbies',
        );

        $values = array(
            'William',
            'Knauss',
            'male',
            array(
                'art',
                'programming',
                'photography',
            ),
        );

        $this->array->refresh($value);

        $this->array->divide();
        $array = $this->array->toArray();

        $this->assertEquals($array[0], $keys);
        $this->assertEquals($array[1], $values);
    }

    public function testdot() {
        $values = array(
            'firstname' => 'William',
            'lastname'  => 'Knauss',
            'gender'    => 'male',
            'hobbies'   => array(
                'art',
                'programming',
                'photography',
            ),
        );

        $outcome = array(
            'firstname' => 'William',
            'lastname'  => 'Knauss',
            'gender'    => 'male',
            'hobbies.0' => 'art',
            'hobbies.1' => 'programming',
            'hobbies.2' => 'photography',
        );

        $this->array->refresh($values);
        $this->array->dot();

        $array = $this->array->toArray();
        $this->assertEquals($outcome, $array);
    }

    public function testexists() {
        $values = array(
            'firstname' => 'William',
        );

        $this->array->refresh($values);

        $this->assertTrue($this->array->exists('firstname'));
    }

    public function testgetdot() {
        $values = array(
            'firstname' => true,
        );

        $this->array->refresh($values);

        $this->assertTrue($this->array->getDot('firstname'));

        $values = array(
            0 => array(
                'developer' => array(
                    'name' => 'William',
                ),
            ),
        );
        $this->array->refresh($values);

        $this->assertEquals($this->array->getDot('0.developer.name'), 'William');
        $this->assertEquals($this->array->getDot('1.developer.name', 'Does not exists yet!'), 'Does not exists yet!');
    }
}
