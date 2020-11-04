<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Core;

use FightTheIce\Datatypes\Compounds\Array_;
use FightTheIce\Datatypes\Compounds\Object_;
use FightTheIce\Datatypes\Pseudo\Mixed_;
use FightTheIce\Datatypes\Pseudo\Number_;
use FightTheIce\Datatypes\Pseudo\String_ as GenericString_;
use FightTheIce\Datatypes\Scalar\Boolean_;
use FightTheIce\Datatypes\Scalar\Float_;
use FightTheIce\Datatypes\Scalar\Integer_;
use FightTheIce\Datatypes\Scalar\String_;
use FightTheIce\Datatypes\Scalar\UnicodeString_;
use FightTheIce\Datatypes\Special\Null_;

class Application
{
    public function __construct(bool $aliasClasses = false, string $ns = '')
    {
        if ($aliasClasses == true) {
            $ns = ltrim($ns, '\\');
            $ns = rtrim($ns, '\\');
            if (!empty($ns)) {
                $ns .= '\\';
            }

            $classes = [
                \FightTheIce\Datatypes\Compounds\Array_::class      => $ns . 'Arr_',
                \FightTheIce\Datatypes\Compounds\Object_::class     => $ns . 'Obj_',
                \FightTheIce\Datatypes\Scalar\Boolean_::class       => $ns . 'Bool_',
                \FightTheIce\Datatypes\Scalar\Float_::class         => $ns . 'Double_',
                \FightTheIce\Datatypes\Scalar\Integer_::class       => $ns . 'Int_',
                \FightTheIce\Datatypes\Scalar\String_::class        => $ns . 'Str_',
                \FightTheIce\Datatypes\Scalar\UnicodeString_::class => $ns . 'UnicodeStr_',
                \FightTheIce\Datatypes\Special\Null_::class         => $ns . 'Null_',
                \FightTheIce\Datatypes\Pseudo\Mixed_::class         => $ns . 'Mixed_',
                \FightTheIce\Datatypes\Pseudo\Number_::class        => $ns . 'Number_',
                \FightTheIce\Datatypes\Pseudo\String_::class        => $ns . 'String_',
            ];

            foreach ($classes as $class => $alias) {
                if (class_exists($alias) == false) {
                    class_alias($class, $alias);
                }
            }
        }
    }

    public static function newArray_(array $default = []): Array_
    {
        return new Array_($default);
    }

    public static function newBoolean_(bool $default = false): Boolean_
    {
        return new Boolean_($default);
    }

    public static function newFloat_(float $default = 0.00): Float_
    {
        return new Float_($default);
    }

    public static function newInteger_(int $default = 0): Integer_
    {
        return new Integer_($default);
    }

    public static function newString_(string $default = ''): String_
    {
        return new String_($default);
    }

    public static function newUnicodeString_(string $default = ''): UnicodeString_
    {
        return new UnicodeString_($default);
    }

    /**
     * newObject_.
     *
     * @param mixed $obj
     *
     * @return Object_
     */
    public static function newObject_($obj = null): Object_
    {
        return new Object_($obj);
    }

    public static function newNull_(): Null_
    {
        return new Null_();
    }

    /**
     * newMixed_.
     *
     * @param mixed $obj
     *
     * @return Mixed_
     */
    public static function newMixed_($obj): Mixed_
    {
        return new Mixed_($obj);
    }

    /**
     * newNumber_.
     *
     * @param int|float $number
     *
     * @return Number_
     */
    public static function newNumber_($number): Number_
    {
        return new Number_($number);
    }

    public static function newGenericString_(string $default = ''): GenericString_
    {
        return new GenericString_($default);
    }
}
