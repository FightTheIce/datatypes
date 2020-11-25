<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use FightTheIce\Datatypes\Scalar\NumberString_;
use FightTheIce\Datatypes\Core\Contracts\ScalarInterface;
use FightTheIce\Datatypes\Core\Contracts\StringInterface;
use FightTheIce\Datatypes\Core\Contracts\IntegerInterface;
use FightTheIce\Datatypes\Core\Contracts\FloatInterface;
use FightTheIce\Datatypes\Core\Contracts\DatatypeInterface;
use FightTheIce\Datatypes\Scalar\Boolean_;
use FightTheIce\Datatypes\Scalar\Integer_;
use FightTheIce\Datatypes\Compound\Array_;
use FightTheIce\Datatypes\Scalar\Float_;
use Brick\Math\BigNumber;
use FightTheIce\Exceptions\ArithmeticError;

final class NumberString__Test extends TestCase
{
    public function test_meta()
    {
        $numstr = new NumberString_();
        $this->assertInstanceOf(NumberString_::class, $numstr);

        $this->assertInstanceOf(StringInterface::class, $numstr);
        $this->assertInstanceOf(IntegerInterface::class, $numstr);
        $this->assertInstanceOf(FloatInterface::class, $numstr);
        $this->assertInstanceOf(ScalarInterface::class, $numstr);
        $this->assertInstanceOf(DatatypeInterface::class, $numstr);
        $this->assertClassHasAttribute('str', NumberString_::class);

        $this->assertClassHasAttribute('macros', NumberString_::class);
    }

    public function test_getPrimitiveType()
    {
        $numstr = new NumberString_();
        $this->assertEquals('string', $numstr->getPrimitiveType());
    }

    public function test_getDatatypeCategory()
    {
        $numstr = new NumberString_();
        $this->assertEquals('scalar', $numstr->getDatatypeCategory());
    }

    public function test_describe()
    {
        $numstr = new NumberString_('1');
        $this->assertEquals('numeric string', $numstr->describe());
    }

    public function test_hasSubject()
    {
        $numstr = new NumberString_();
        $this->assertTrue(method_exists($numstr, '__toString'));
        $this->assertTrue(method_exists($numstr, '__toInteger'));
        $this->assertTrue(method_exists($numstr, '__toFloat'));
    }

    public function test_construct_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $numstr = new NumberString_('abc');
    }

    public function test__toString()
    {
        $numstr = new NumberString_('0x313030');
        $this->assertSame('100', $numstr->__toString());

        $numstr = new NumberString_('0144');
        $this->assertSame('100', $numstr->__toString());

        $numstr = new NumberString_('0b1100100');
        $this->assertSame('100', $numstr->__toString());

        $numstr = new NumberString_('1e2');
        $this->assertSame('100', $numstr->__toString());
    }

    public function test_ltrim()
    {
        $numstr = new NumberString_('111200');
        $ltrim  = $numstr->ltrim('1');
        $this->assertIsObject($ltrim);
        $this->assertInstanceOf(NumberString_::class, $ltrim);
        $this->assertSame('200', $ltrim->__toString());

        $numstr = new NumberString_('  111200');
        $this->assertSame('111200', $numstr->ltrim()->__toString());
    }

    public function test_rtrim()
    {
        $numstr = new NumberString_('1222222');
        $rtrim  = $numstr->rtrim('2');
        $this->assertIsObject($rtrim);
        $this->assertInstanceOf(NumberString_::class, $rtrim);
        $this->assertSame('1', $rtrim->__toString());

        $numstr = new NumberString_('1222220000');
        $this->assertSame('1222220000', $numstr->rtrim()->__toString());
    }

    public function test_trim()
    {
        $numstr = new NumberString_('01230');
        $trim   = $numstr->trim();
        $this->assertIsObject($trim);
        $this->assertInstanceOf(NumberString_::class, $trim);
        $this->assertSame('664', $trim->__toString());

        $numstr = new NumberString_('11231');
        $this->assertSame('23', $numstr->trim('1')->__toString());
    }

    public function test_substr()
    {
        $numstr = new NumberString_('0123');
        $substr = $numstr->substr(1);
        $this->assertIsObject($substr);
        $this->assertInstanceOf(NumberString_::class, $substr);
        $this->assertSame('3', $substr->__toString());

        $numstr = new NumberString_('123456');
        $this->assertSame('23', $numstr->substr(1, 2)->__toString());
    }

    public function test_strtolower()
    {
        $numstr = new NumberString_('1234');
        $lower  = $numstr->strtolower();
        $this->assertIsObject($lower);
        $this->assertInstanceOf(NumberString_::class, $lower);
        $this->assertSame('1234', $lower->__toString());
    }

    public function test_strtoupper()
    {
        $numstr = new NumberString_('1234');
        $upper  = $numstr->strtoupper();
        $this->assertIsObject($upper);
        $this->assertInstanceOf(NumberString_::class, $upper);
        $this->assertSame('1234', $upper->__toString());
    }

    public function test_isEmpty()
    {
        $numstr = new NumberString_();
        $empty  = $numstr->isEmpty();
        $this->assertIsObject($empty);
        $this->assertInstanceOf(Boolean_::class, $empty);
        $this->assertTrue($empty->isTrue());

        $numstr = new NumberString_('1234');
        $this->assertFalse($numstr->isEmpty()->isTrue());
    }

    public function test_strlen()
    {
        $numstr = new NumberString_();
        $strlen = $numstr->strlen();
        $this->assertIsObject($strlen);
        $this->assertInstanceOf(Integer_::class, $strlen);
        $this->assertSame(1, $strlen->getNumber());
    }

    public function test_str_split()
    {
        $numstr    = new NumberString_();
        $str_split = $numstr->str_split();
        $this->assertIsObject($str_split);
        $this->assertInstanceOf(Array_::class, $str_split);
        $this->assertSame(['0'], $str_split->__toArray());

        $numstr = new NumberString_('1234');
        $this->assertSame(['12', '34'], $numstr->str_split(2)->__toArray());
    }

    public function test_isPositive()
    {
        $numstr = new NumberString_('1');
        $bool   = $numstr->isPositive();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());

        $numstr = new NumberString_('-1');
        $this->assertFalse($numstr->isPositive()->isTrue());

        $numstr = new NumberString_('+1');
        $this->assertTrue($numstr->isPositive()->isTrue());
    }

    public function test_isNegative()
    {
        $numstr = new NumberString_('-1');
        $bool   = $numstr->isNegative();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());

        $numstr = new NumberString_('+1');
        $this->assertFalse($numstr->isNegative()->isTrue());
    }

    public function test_isZero()
    {
        $numstr = new NumberString_('0');
        $bool   = $numstr->isZero();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());
    }

    public function test_getNumber()
    {
        $numstr = new NumberString_('123');
        $num    = $numstr->getNumber();
        $this->assertIsString($num);
        $this->assertSame('123', $num);
    }

    public function test__toFloat()
    {
        $numstr = new NumberString_('123.123');
        $float  = $numstr->__toFloat();
        $this->assertIsObject($float);
        $this->assertInstanceOf(Float_::class, $float);
        $this->assertSame(123.123, $float->getNumber());
    }

    public function test__toInteger()
    {
        $numstr = new NumberString_('123');
        $int    = $numstr->__toInteger();
        $this->assertIsObject($int);
        $this->assertInstanceOf(Integer_::class, $int);
        $this->assertSame(123, $int->getNumber());
    }

    public function test_absolute()
    {
        $numstr = new NumberString_('-100');
        $abs    = $numstr->absolute();
        $this->assertIsObject($abs);
        $this->assertInstanceOf(NumberString_::class, $abs);
        $this->assertSame('100', $abs->getNumber());

        $numstr = new NumberString_('+100');
        $this->assertSame('100', $numstr->absolute()->getNumber());

        $numstr = new NumberString_('100');
        $this->assertSame('100', $numstr->absolute()->getNumber());
    }

    public function test_negated()
    {
        $numstr = new NumberString_('-100');
        $abs    = $numstr->negated();
        $this->assertIsObject($abs);
        $this->assertInstanceOf(NumberString_::class, $abs);
        $this->assertSame('100', $abs->getNumber());

        $numstr = new NumberString_('+100');
        $this->assertSame('-100', $numstr->negated()->getNumber());

        $numstr = new NumberString_('100');
        $this->assertSame('-100', $numstr->negated()->getNumber());
    }

    public function test_negativeabsolute()
    {
        $numstr = new NumberString_('-100');
        $abs    = $numstr->negativeabsolute();
        $this->assertIsObject($abs);
        $this->assertInstanceOf(NumberString_::class, $abs);
        $this->assertSame('-100', $abs->getNumber());

        $numstr = new NumberString_('+100');
        $this->assertSame('-100', $numstr->negativeabsolute()->getNumber());

        $numstr = new NumberString_('100');
        $this->assertSame('-100', $numstr->negativeabsolute()->getNumber());
    }

    public function test_math()
    {
        $numstr = new NumberString_('100');
        $math   = $numstr->math();
        $this->assertIsObject($math);
        $this->assertInstanceOf(BigNumber::class, $math);
    }

    public function test_is_string_float()
    {
        $numstr = new NumberString_('9,223,372,036,854,775,807,000,001,002,003.12345452432');
        $bool   = $numstr->is_string_float();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());

        $numstr = new NumberString_('9,223,372,036,854,775,807,000,001,002,003');
        $this->assertFalse($numstr->is_string_float()->isTrue());
    }

    public function test_is_string_integer()
    {
        $numstr = new NumberString_('9,223,372,036,854,775,807,000,001,002,003');
        $bool   = $numstr->is_string_integer();
        $this->assertIsObject($bool);
        $this->assertInstanceOf(Boolean_::class, $bool);
        $this->assertTrue($bool->isTrue());

        $numstr = new NumberString_('9,223,372,036,854,775,807,000,001,002,003.12312435');
        $this->assertFalse($numstr->is_string_integer()->isTrue());
    }

    public function test__toFloat_exception()
    {
        $this->expectException(ArithmeticError::class);
        $numstr = new NumberString_('1');
        $numstr->__toFloat();
    }

    public function test__toInteger_exception()
    {
        $this->expectException(ArithmeticError::class);
        $numstr = new NumberString_('1.21232');
        $numstr->__toInteger();
    }
}
