<?php
declare (strict_types = 1);

namespace FightTheIce\Datatypes\Pseudo;

use FightTheIce\Datatypes\Compounds\Array_;
use FightTheIce\Datatypes\Compounds\Object_;
use FightTheIce\Datatypes\Core\Datatype;
use FightTheIce\Datatypes\Scalar\Boolean_;
use FightTheIce\Datatypes\Scalar\Float_;
use FightTheIce\Datatypes\Scalar\Integer_;
use FightTheIce\Datatypes\Scalar\String_;
use FightTheIce\Datatypes\Scalar\UnicodeString_;
use FightTheIce\Datatypes\Special\Null_;
use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\Support\Traits\Macroable;

class Mixed_ implements Datatype
{
    use Macroable {
        __call as __parentcall;
    }

    use ForwardsCalls;

    protected $object;
    protected Datatype $class;

    public function __construct($obj)
    {
        $this->object = $obj;

        switch (strtolower(gettype($obj))) {
            case 'array':
                $this->class = new Array_($obj);
                break;

            case 'string':
                //https://stackoverflow.com/questions/1350758/check-unicode-in-php
                //we need to determine unicode or not
                if (strlen($obj) != strlen(utf8_decode($obj))) {
                    //unicode
                    $this->class = new UnicodeString_($obj);
                } else {
                    //no unicode
                    $this->class = new String_($obj);
                }
                break;

            case 'boolean':
            case 'bool':
                $this->class = new Boolean_($obj);
                break;

            case 'double':
            case 'float':
                $this->class = new Float_($obj);
                break;

            case 'integer':
            case 'int':
                $this->class = new Integer_($obj);
                break;

            case 'object':
                $this->class = new Object_($obj);
                break;

            case 'null';
                $this->class = new Null_();
                break;

            default:
                echo PHP_EOL;
                echo gettype($obj) . PHP_EOL;
                echo '----EXIT';
                exit;
        }
    }

    public function getValue()
    {
        return $this->object;
    }

    public function getClass(): Datatype
    {
        return $this->class;
    }

    public function __call($method, $parameters)
    {
        if (method_exists($this->class, $method)) {
            return $this->forwardCallTo($this->class, $method, $parameters);
        }

        return $this->__parentcall($method, $parameters);
    }
}
