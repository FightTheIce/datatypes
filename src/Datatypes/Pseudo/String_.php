<?php
declare (strict_types = 1);

namespace FightTheIce\Datatypes\Pseudo;

use FightTheIce\Datatypes\Core\Datatype;
use FightTheIce\Datatypes\Scalar\String_ as SString_;
use FightTheIce\Datatypes\Scalar\UnicodeString_;
use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\Support\Traits\Macroable;

class String_ implements Datatype
{
    use Macroable {
        __call as __parentcall;
    }

    use ForwardsCalls;

    protected string $string;
    protected Datatype $class;

    function __construct(string $obj)
    {
        $this->string = $obj;

        if (strlen($obj) != strlen(utf8_decode($obj))) {
            //unicode
            $this->class = new UnicodeString_($obj);
        }

        //no unicode
        $this->class = new String_($obj);

    }

    /**
     * @return string
     */
    function getValue()
    {
        return $this->string;
    }

    function getClass(): Datatype
    {
        return $this->class;
    }

    function __call($method, $parameters)
    {
        if (method_exists($this->class, $method)) {
            return $this->forwardCallTo($this->class, $method, $parameters);
        }

        return $this->__parentcall($method, $parameters);
    }
}
