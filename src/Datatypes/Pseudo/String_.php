<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Pseudo;

use FightTheIce\Datatypes\Core\Contracts\Datatype;
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

    public function __construct(string $obj)
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
    public function getValue()
    {
        return $this->string;
    }

    public function getClass(): Datatype
    {
        return $this->class;
    }

    /**
     * __call.
     *
     * @param string $method
     * @param mixed  $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (method_exists($this->class, $method)) {
            return $this->forwardCallTo($this->class, $method, $parameters);
        }

        return $this->__parentcall($method, $parameters);
    }
}
