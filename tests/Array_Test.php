<?php

namespace FightTheIce\Tests\Datatypes;
use FightTheIce\Datatypes\Datatype\Array_;
use FightTheIce\PHPUnit\Assertions\TestCase;

class Array_Test extends TestCase {
    protected $array = null;

    public function setUp(): void{
        $this->array = new Array_();
    }

    public function testClassData() {
        $this->assertInstanceOf(\FightTheIce\Datatypes\Datatype\Array_::class, $this->array);

        $this->assertClassImplements(\FightTheIce\Datatypes\Core\Interfaces\DatatypeInterface::class, $this->array);
        $this->assertClassImplements(\ArrayAccess::class, $this->array);
        $this->assertClassImplements(\IteratorAggregate::class, $this->array);

        $this->assertClassHasTrait(\Illuminate\Support\Traits\ForwardsCalls::class, $this->array);
        $this->assertClassHasTrait(\Illuminate\Support\Traits\Macroable::class, $this->array);

        $this->assertClassHasProperty('collection', \FightTheIce\Datatypes\Datatype\Array_::class);
        $this->assertClassHasProperty('arr', \FightTheIce\Datatypes\Datatype\Array_::class);
    }

    public function test__construct() {
        //__construct(array $arr = [])
        $methodName = '__construct';
        $this->assertMethodExists($methodName, $this->array);

        $this->assertMethodIsPublic($methodName, $this->array);

        $this->assertMethodHasParameter('arr', $methodName, $this->array);

        $this->assertMethodParameterIsOptional('arr', $methodName, $this->array);

        $this->assertMethodParameterTypeHintIs('array', 'arr', $methodName, $this->array);

        $this->assertMethodParameterDefaultValueIs([], 'arr', $methodName, $this->array);

        //__construct can be called with no parameters (the example is with the property $this->array)

        //__construct can be called with arr parameter equaling an array
        $new = new Array_(array(1, 2, 3));
        $this->assertInstanceOf(\FightTheIce\Datatypes\Datatype\Array_::class, $new);

        //__construct can be called with arr parameter not being an array
        $this->expectException(\Error::class);
        $new = new Array_(new stdClass());
    }

    public function testgetType() {
        //getType()
        $methodName = 'getType';
        $this->assertMethodExists($methodName, $this->array);

        $this->assertMethodIsPublic($methodName, $this->array);

        $this->assertEquals('array', $this->array->getType());
    }

    public function testgetValue() {
        //getValue()
        $methodName = 'getValue';

        $this->assertMethodExists($methodName, $this->array);

        $this->assertMethodIsPublic($methodName, $this->array);

        $this->assertEquals(array(), $this->array->getValue());

        //now lets add something to the array
        //to do this we will just re-init our array property
        $value       = array(1, 2, 3);
        $this->array = new Array_($value);
        $this->assertEquals($value, $this->array->getValue());
    }

    public function testoffsetExists() {
        //offsetExists($offset)
        $methodName = 'offsetExists';

        $this->assertMethodExists($methodName, $this->array);

        $this->assertMethodIsPublic($methodName, $this->array);

        $this->assertMethodHasParameter('offset', $methodName, $this->array);

        $this->assertMethodParameterIsRequired('offset', $methodName, $this->array);

        //by default we should have no offsets
        $this->assertEquals(false, $this->array->offsetExists(0));

        //now lets add one and make sure it does indeed exists
        $this->array = new Array_(array(0 => 'frog'));
        $this->assertEquals(true, $this->array->offsetExists(0));
    }

    public function testoffsetGet() {
        //offsetGet($offset)
        $methodName = 'offsetGet';

        $this->assertMethodExists($methodName, $this->array);

        $this->assertMethodIsPublic($methodName, $this->array);

        $this->assertMethodHasParameter('offset', $methodName, $this->array);

        $this->assertMethodParameterIsRequired('offset', $methodName, $this->array);

        //by default we should have no offsets
        $this->assertNull($this->array->offsetGet(0));

        //now lets add one and get its value
        $this->array = new Array_(array(0 => 'frog'));
        $this->assertEquals('frog', $this->array->offsetGet(0));
    }

    public function testoffsetSet() {
        //offsetSet($offset, $value)
        $methodName = 'offsetSet';

        $this->assertMethodExists($methodName, $this->array);

        $this->assertMethodIsPublic($methodName, $this->array);

        $this->assertMethodHasParameter('offset', $methodName, $this->array);
        $this->assertMethodHasParameter('value', $methodName, $this->array);

        $this->assertMethodParameterIsRequired('offset', $methodName, $this->array);
        $this->assertMethodParameterIsRequired('value', $methodName, $this->array);

        //by default we have no offsets so lets add one now
        $this->array->offsetSet(0, 'frog');

        $this->assertEquals('frog', $this->array->offsetGet(0));

        //we should also be able to overwrite an existing offset
        $this->array->offsetSet(0, 'cow');

        $this->assertEquals('cow', $this->array->offsetGet(0));

        //reset
        $this->setUp();

        //our offset key can be equals to "null" which in turn "auto indexes" the array
        $this->array->offsetSet(null, 'frog');
        $this->assertEquals('frog', $this->array->offsetGet(0));
    }

    public function testoffsetUnset() {
        //offsetUnset($offset)
        $methodName = 'offsetUnset';

        $this->assertMethodExists($methodName, $this->array);

        $this->assertMethodIsPublic($methodName, $this->array);

        $this->assertMethodHasParameter('offset', $methodName, $this->array);

        $this->assertMethodParameterIsRequired('offset', $methodName, $this->array);

        //by default we have no offsets so lets add one now
        $this->array->offsetSet(0, 'frog');

        //now lets unset
        $this->array->offsetUnset(0);

        //now lets try to get it... and we should get null
        $this->assertNull($this->array->offsetGet(0));
    }

    public function testaddDot() {
        //addDot(string $key, $value)
        $methodName = 'addDot';

        $this->assertMethodExists($methodName, $this->array);

        $this->assertMethodIsPublic($methodName, $this->array);

        $this->assertMethodHasParameter('key', $methodName, $this->array);
        $this->assertMethodHasParameter('value', $methodName, $this->array);

        $this->assertMethodParameterIsRequired('key', $methodName, $this->array);
        $this->assertMethodParameterIsRequired('value', $methodName, $this->array);

        //we can add a "simple" key 1,2,3, etc
        $this->array->addDot(0, 'frog');

        $this->assertEquals('frog', $this->array->offsetGet(0));

        //reset
        $this->setUp();

        //we can add a more complete depth such as 0.developer.id
        $this->array->addDot('0.developer.id', 1);

        $this->assertEquals(array(
            'developer' => array(
                'id' => 1,
            ),
        ), $this->array->offsetGet(0));

        //we can also overwrite an existing value
        $this->array->addDot('0.developer.id', 2);

        $this->assertEquals(array(
            'developer' => array(
                'id' => 2,
            ),
        ), $this->array->offsetGet(0));

        //reset
        $this->setUp();

        //the returned value from this method should always be an instance of the class
        $instanceOf = $this->array->addDot('0.developer.id', 1);
        $this->assertInstanceOf(\FightTheIce\Datatypes\Datatype\Array_::class, $instanceOf);

        //it should also be the same object as the array property
        $this->assertEquals($instanceOf, $this->array);

        //reset
        $this->setUp();

        //if we call addDot without required parameters we should get an exception
        $this->expectException(\Error::class);
        $this->addDot();
    }

    public function testremoveDot() {
        //removeDot(string $key)
        $methodName = 'removeDot';

        $this->assertMethodExists($methodName, $this->array);

        $this->assertMethodIsPublic($methodName, $this->array);

        $this->assertMethodHasParameter('key', $methodName, $this->array);

        $this->assertMethodParameterIsRequired('key', $methodName, $this->array);

        $this->assertMethodParameterTypeHintIs('string', 'key', $methodName, $this->array);

        //by default we have no offsets/keys so lets add one
        $this->array->addDot(0, 'hello world');

        //now lets remove it
        $this->array->removeDot(0);

        //now check for it
        $this->assertNull($this->array->offsetGet(0));

        //reset
        $this->setUp();

        //now lets add an more complex example
        $this->array->addDot('0.developer.id', 1);

        //now if we remove 0.developer.id we should still have 0.developer
        $this->array->removeDot('0.developer.id');

        $this->assertEquals(array(
            'developer' => array(),
        ), $this->array->offsetGet(0));

        //now if we remove dot "0" ... the entire array should disappear
        $this->array->removeDot(0);

        $this->assertEquals(null, $this->array->offsetGet(0));

        //reset
        $this->setUp();

        //removing a dot (depth) that doesn't exist shouldn't do anything
        $this->array->removeDot('0.1.2');

        $this->assertEquals(null, $this->array->offsetGet(0));

        //reset
        $this->setUp();

        //the returned value from this method should always be an instance of the class
        $instanceOf = $this->array->removeDot('0.developer.id');
        $this->assertInstanceOf(\FightTheIce\Datatypes\Datatype\Array_::class, $instanceOf);

        //it should also be the same object as the array property
        $this->assertEquals($instanceOf, $this->array);

        //reset
        $this->setUp();

        //if we call addDot without required parameters we should get an exception
        $this->expectException(\Error::class);
        $this->removeDot();
    }

    public function testdivide() {
        //divide()
        $methodName = 'divide';

        $this->assertMethodExists($methodName, $this->array);

        $this->assertMethodIsPublic($methodName, $this->array);

        //by default there are no offsets/keys so dividing should give us an empty array set back
        $this->array->divide();

        $this->assertEquals(array(), $this->array->offsetGet(0));
        $this->assertEquals(array(), $this->array->offsetGet(1));

        //reset
        $this->setUp();

        //lets add some data
        $this->array->addDot('name', 'Desk');
        $this->assertEquals('Desk', $this->array->offsetGet('name'));

        //now lets divide
        $this->array->divide();

        $this->assertEquals(array('name'), $this->array->offsetGet(0));
        $this->assertEquals(array('Desk'), $this->array->offsetGet(1));

        //reset
        $this->setUp();

        //the returned value from this method should always be an instance of the class
        $instanceOf = $this->array->divide();
        $this->assertInstanceOf(\FightTheIce\Datatypes\Datatype\Array_::class, $instanceOf);

        //it should also be the same object as the array property
        $this->assertEquals($instanceOf, $this->array);
    }

    public function testDot() {
        //dot($prepend = '')
        $methodName = 'dot';

        $this->assertMethodExists($methodName, $this->array);

        $this->assertMethodIsPublic($methodName, $this->array);

        $this->assertMethodHasParameter('prepend', $methodName, $this->array);

        $this->assertMethodParameterIsOptional('prepend', $methodName, $this->array);

        $this->assertMethodParameterTypeHintIs('string', 'prepend', $methodName, $this->array);

        $this->assertMethodParameterDefaultValueIs('', 'prepend', $methodName, $this->array);

        //by default no offsets/keys exists so we should get nothing
        $this->array->dot();

        $this->assertNull($this->array->offsetGet(0));

        //reset
        $this->setUp();

        //now lets add some data
        $this->array->addDot('families', array('Shoemaker', 'Smith', 'Black'));

        //now lets dot this data
        $this->array->dot();

        $this->assertEquals('Shoemaker', $this->array->offsetGet('families.0'));
        $this->assertEquals('Smith', $this->array->offsetGet('families.1'));
        $this->assertEquals('Black', $this->array->offsetGet('families.2'));

        //reset
        $this->setUp();

        //this should also leave existing 1-d nodes along
        $this->array->addDot('color', 'yellow');
        $this->array->addDot('families', array('Plain', 'Jane', 'Apple'));

        $this->array->dot();

        $this->assertEquals('Plain', $this->array->offsetGet('families.0'));
        $this->assertEquals('Jane', $this->array->offsetGet('families.1'));
        $this->assertEquals('Apple', $this->array->offsetGet('families.2'));
        $this->assertEquals('yellow', $this->array->offsetGet('color'));

        //reset
        $this->setUp();

        //this method also allows us to prepend a string to keys that are dotted
        $this->array->addDot('animal', 'frog');
        $this->array->addDot('fruits', array('grape', 'orange', 'onion'));

        $this->array->dot('--');

        $this->assertEquals('grape', $this->array->offsetGet('--fruits.0'));
        $this->assertEquals('orange', $this->array->offsetGet('--fruits.1'));
        $this->assertEquals('onion', $this->array->offsetGet('--fruits.2'));
        $this->assertEquals('frog', $this->array->offsetGet('--animal'));

        //reset
        $this->setUp();

        //now what if we want a really deep nested array
        $this->array->addDot(0, array(
            'William' => array(
                'name'            => 'William',
                'favorite_colors' => array(
                    'red',
                    'green',
                    'blue',
                ),
                'programming'     => array(
                    'php'  => array(
                        '7.1',
                        '7.2',
                    ),
                    '.net' => array(
                        'vb' => array(
                            '1', '2', '3',
                        ),
                    ),
                ),
            ),
        ));
        $this->array->dot();

        $this->assertEquals('William', $this->array->offsetGet('0.William.name'));
        $this->assertEquals('red', $this->array->offsetGet('0.William.favorite_colors.0'));
        $this->assertEquals('green', $this->array->offsetGet('0.William.favorite_colors.1'));
        $this->assertEquals('blue', $this->array->offsetGet('0.William.favorite_colors.2'));
        $this->assertEquals('7.1', $this->array->offsetGet('0.William.programming.php.0'));
        $this->assertEquals('7.2', $this->array->offsetGet('0.William.programming.php.1'));
        $this->assertEquals('1', $this->array->offsetGet('0.William.programming..net.vb.0'));
        $this->assertEquals('2', $this->array->offsetGet('0.William.programming..net.vb.1'));
        $this->assertEquals('3', $this->array->offsetGet('0.William.programming..net.vb.2'));

        //reset
        $this->setUp();

        //the returned value from this method should always be an instance of the class
        $instanceOf = $this->array->dot();
        $this->assertInstanceOf(\FightTheIce\Datatypes\Datatype\Array_::class, $instanceOf);

        //it should also be the same object as the array property
        $this->assertEquals($instanceOf, $this->array);
    }

    public function testexists() {
        //exists($key)
        $methodName = 'exists';

        $this->assertMethodExists($methodName, $this->array);

        $this->assertMethodIsPublic($methodName, $this->array);

        $this->assertMethodHasParameter('key', $methodName, $this->array);

        $this->assertMethodParameterIsRequired('key', $methodName, $this->array);

        //this is just an alias call to $this->offsetExists
        $this->assertFalse($this->array->exists(0));

        //reset
        $this->setUp();

        //if we call addDot without required parameters we should get an exception
        $this->expectException(\Error::class);
        $this->array->exists();
    }

    public function testgetDot() {
        //getDot($key, $default = null)
        $methodName = 'getDot';

        $this->assertMethodExists($methodName, $this->array);

        $this->assertMethodIsPublic($methodName, $this->array);

        $this->assertMethodHasParameter('key', $methodName, $this->array);
        $this->assertMethodHasParameter('default', $methodName, $this->array);

        $this->assertMethodParameterIsRequired('key', $methodName, $this->array);
        $this->assertMethodParameterIsOptional('default', $methodName, $this->array);

        $this->assertMethodParameterDefaultValueIs(null, 'default', $methodName, $this->array);

        //by default there are no offsets/keys
        $this->assertEquals(null, $this->array->offsetGet(0));

        //now lets add one using addDot
        $this->array->addDot(0, 'frog');
        $this->assertEquals('frog', $this->array->offsetGet(0));

        $value = $this->array->getDot(0);
        $this->assertEquals('frog', $value);

        //reset
        $this->setUp();

        //getDot also lets us create a offset if we supply a default value
        $this->array->getDot('0.developers.id', 1);
        $this->assertEquals(array(
            'developers' => array(
                'id' => 1,
            ),
        ), $this->array->offsetGet(0));

        //reset
        $this->setUp();

        //getDot only creates an offset if we supply a default value that is not null
        //so supplying a value that is null should not create the value
        $this->array->getDot('0.developers.id', null);
        $this->assertEquals(null, $this->array->offsetGet(0));

        //reset
        $this->setUp();

        //if we call getDot without required parameters we should get an exception
        $this->expectException(\Error::class);
        $this->array->getDot();
    }

    public function testisAssoc() {
        //isAssoc()
        $methodName = 'isAssoc';

        $this->assertMethodExists($methodName, $this->array);

        $this->assertMethodIsPublic($methodName, $this->array);

        //by default there are no offsets/keys so this should do nothing?
        $this->assertFalse($this->array->isAssoc());

        //now lets add a offset starting at 1
        $this->array->addDot(1, 'some value');

        $this->assertTrue($this->array->isAssoc());

        //reset
        $this->setUp();

        //now lets add a key that is not numeric
        $this->array->addDot('animal', 'frog');

        $this->assertTrue($this->array->isAssoc());

        //reset
        $this->setUp();

        //now lets add setup an non assoc array
        $this->array->addDot(0, 'some value');
        $this->array->addDot(1, 'some value');
        $this->array->addDot(2, 'some other value');

        $this->assertFalse($this->array->isAssoc());
    }

    public function testsetDot() {
        //setDot($key, $value)
        $methodName = 'setDot';

        $this->assertMethodExists($methodName, $this->array);

        $this->assertMethodIsPublic($methodName, $this->array);

        $this->assertMethodHasParameter('key', $methodName, $this->array);
        $this->assertMethodHasParameter('value', $methodName, $this->array);

        $this->assertMethodParameterIsRequired('key', $methodName, $this->array);
        $this->assertMethodParameterIsRequired('value', $methodName, $this->array);

        //so the Illuminate\Support\Arr class method add - will only add non existing keys
        //so if a key exists already and you want to overwrite it you have to call
        //Illuminate\Support\Arr::setDot
        //I didn't like this behavior so in our Array_ class addDot will allow you to
        //overwrite a value

        //by default there are no offsets/keys
        //lets add one
        $this->array->setDot(0, 'frog');
        $this->assertEquals('frog', $this->array->offsetGet(0));

        //we can also overwrite a value
        $this->array->setDot(0, 'rabbit');
        $this->assertEquals('rabbit', $this->array->offsetGet(0));

        //reset
        $this->setUp();

        //now for a more complex example
        $this->array->setDot('0.developers.id', 1);
        $this->assertEquals(array(
            'developers' => array(
                'id' => 1,
            ),
        ), $this->array->offsetGet(0));

        //we can overwrite our example
        $this->array->setDot('0.developers.id', 0);
        $this->assertEquals(array(
            'developers' => array(
                'id' => 0,
            ),
        ), $this->array->offsetGet(0));

        //we can overwrite all the way to base
        $this->array->setDot(0, array());
        $this->assertEquals(array(), $this->array->offsetGet(0));

        //reset
        $this->setUp();

        //the returned value from this method should always be an instance of the class
        $instanceOf = $this->array->setDot('0.developer.id', 1);
        $this->assertInstanceOf(\FightTheIce\Datatypes\Datatype\Array_::class, $instanceOf);

        //it should also be the same object as the array property
        $this->assertEquals($instanceOf, $this->array);

        //reset
        $this->setUp();

        //if we call getDot without required parameters we should get an exception
        $this->expectException(\Error::class);
        $this->array->setDot();
    }

    public function testquery() {
        //query()
        $methodName = 'query';

        $this->assertMethodExists($methodName, $this->array);

        $this->assertMethodIsPublic($methodName, $this->array);

        //by default there is nothing
        $this->assertEquals('', $this->array->query());

        //now lets add something
        $this->array->setDot('name', 'William');

        $this->assertEquals('name=William', $this->array->query());

        //reset
        $this->setUp();

        //for a more complex example
        $this->array = new Array_(['name' => 'Taylor', 'order' => ['column' => 'created_at', 'direction' => 'desc']]);

        $this->assertEquals('name=Taylor&order%5Bcolumn%5D=created_at&order%5Bdirection%5D=desc', $this->array->query());
    }

    public function testwhere() {
        //where(callable $callback)
        $methodName = 'where';

        $this->assertMethodExists($methodName, $this->array);

        $this->assertMethodIsPublic($methodName, $this->array);

        $this->assertMethodHasParameter('callback', $methodName, $this->array);

        $this->assertMethodParameterIsRequired('callback', $methodName, $this->array);

        $this->assertMethodParameterTypeHintIs('callable', 'callback', $methodName, $this->array);

        //reset
        $this->array = new Array_([100, '200', 300, '400', 500]);

        $this->array->where(function ($value, $key) {
            return is_string($value);
        });

        $this->assertEquals('200', $this->array->offsetGet(1));
        $this->assertEquals('400', $this->array->offsetGet(3));

        //reset
        $this->setUp();

        //the returned value from this method should always be an instance of the class
        $instanceOf = $this->array->where(function ($value, $key) {
            return true;
        });

        $this->assertInstanceOf(\FightTheIce\Datatypes\Datatype\Array_::class, $instanceOf);

        //it should also be the same object as the array property
        $this->assertEquals($instanceOf, $this->array);

        //reset
        $this->setUp();

        //if we call getDot without required parameters we should get an exception
        $this->expectException(\Error::class);
        $this->array->where();
    }

    public function testhasDot() {
        //hasDot(string $key)
        $methodName = 'hasDot';

        $this->assertMethodExists($methodName, $this->array);

        $this->assertMethodIsPublic($methodName, $this->array);

        $this->assertMethodHasParameter('key', $methodName, $this->array);

        $this->assertMethodParameterIsRequired('key', $methodName, $this->array);

        $this->assertMethodParameterTypeHintIs('string', 'key', $methodName, $this->array);

        //by default no offsets/keys exists
        $this->assertFalse($this->array->hasDot(0));

        $this->array->setDot(0, 'frog');
        $this->assertTrue($this->array->hasDot(0));

        //reset
        $this->setUp();

        $this->array->setDot('0.developers.id', 1);
        $this->assertTrue($this->array->hasDot('0.developers'));

        //reset
        $this->setUp();

        //if we call getDot without required parameters we should get an exception
        $this->expectException(\Error::class);
        $this->array->hasDot();
    }

    public function testgetIterator() {
        //getIterator()
        $methodName = 'getIterator';

        $this->assertMethodExists($methodName, $this->array);

        $this->assertMethodIsPublic($methodName, $this->array);

        $Iterator = $this->array->getIterator();
        $this->assertInstanceOf(\ArrayIterator::class, $Iterator);
    }

    public function test__call() {
        //__call(string $name, array $arguments)
        $methodName = '__call';

        $this->assertMethodExists($methodName, $this->array);

        $this->assertMethodIsPublic($methodName, $this->array);

        $this->assertMethodHasParameter('name', $methodName, $this->array);
        $this->assertMethodHasParameter('arguments', $methodName, $this->array);

        $this->assertMethodParameterIsRequired('name', $methodName, $this->array);
        $this->assertMethodParameterIsRequired('arguments', $methodName, $this->array);

        $this->assertMethodParameterTypeHintIs('string', 'name', $methodName, $this->array);
        $this->assertMethodParameterTypeHintIs('array', 'arguments', $methodName, $this->array);

        //__call is a special method - in our case we look for a method name ($name) in the class property
        //collection - if we have it then it gets execute. If the response is an instance of ArrayAccess then
        //we update our class property collection with a new Collection(of the response)
        //if the response is not an instance of ArrayAccess then we directly return that response...
        //
        //if the collection object does not have a method named ($name) then we push the call over to
        //the macroable trait...

        //lets give some default data
        $this->array = new Array_(array(
            'Taylor',
            'Abigail',
            null,
        ));

        //now lets call a method that exists on the collection object
        $this->assertEquals(array('Taylor', 'Abigail', null), $this->array->toArray());

        //now lets call a method on that collection object that will directly return ArrayAccess
        //which should return an instance of the class
        $instanceOf = $this->array->reject(function ($name) {
            return !is_string($name);
        });

        $this->assertInstanceOf(\FightTheIce\Datatypes\Datatype\Array_::class, $instanceOf);

        //it should also be the same object as the array property
        $this->assertEquals($instanceOf, $this->array);

        $this->assertEquals(array('Taylor', 'Abigail'), $this->array->toArray());

        //now lets add a macro to our Array_ object
        $this->array->macro('toUpper', function () {
            return $this->map(function ($value) {
                return strtoupper($value);
            });
        });

        $this->array->toUpper();

        $this->assertEquals(array('TAYLOR', 'ABIGAIL'), $this->array->toArray());

        //reset
        $this->setUp();

        //now lets call a macro that doesn't exists
        $this->expectException(\BadMethodCallException::class);
        $this->array->noarealfunction();
    }

    public function testrefresh() {
        //refresh(array $arr = [])
        $methodName = 'refresh';

        $this->assertMethodExists($methodName, $this->array);

        $this->assertMethodIsPublic($methodName, $this->array);

        $this->assertMethodHasParameter('arr', $methodName, $this->array);

        $this->assertMethodParameterIsOptional('arr', $methodName, $this->array);

        $this->assertMethodParameterTypeHintIs('array', 'arr', $methodName, $this->array);

        //this method is nothing more than a non static call to the constructor... which under
        //the hood is just a direct call to class::__construct
        $this->array->refresh(array('Fred'));

        $this->assertEquals(array('Fred'), $this->array->toArray());
    }

    public function test_using_obj_as_array() {
        $this->array['name'] = 'William';

        $this->assertSame('William', $this->array->offsetGet('name'));

        $this->array['name'] = 'Donald';
        $this->assertSame('Donald', $this->array->offsetGet('name'));

        $this->array[0] = 'Fred';
        $this->assertSame('Fred', $this->array->offsetGet(0));
    }
}
