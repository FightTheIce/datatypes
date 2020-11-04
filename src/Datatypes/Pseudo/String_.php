<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Pseudo;

use FightTheIce\Datatypes\Core\Contracts\DatatypeInterface;
use FightTheIce\Datatypes\Scalar\UnicodeString_;
use FightTheIce\Datatypes\Scalar\String_ as NonUnicodeString_;
use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\Support\Traits\Macroable;
use FightTheIce\Datatypes\Core\Contracts\ResolvableInterface;

class String_ implements DatatypeInterface, ResolvableInterface
{
    use Macroable {
        __call as __parentcall;
    }

    use ForwardsCalls;

    protected string $string;
    protected DatatypeInterface $class;

    public function __construct(string $obj = '')
    {
        $this->string = $obj;

        if (strlen($obj) != strlen(utf8_decode($obj))) {
            //unicode
            $this->class = new UnicodeString_($obj);
        } else {
            //no unicode
            $this->class = new NonUnicodeString_($obj);
        }
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->string;
    }

    public function getClass(): DatatypeInterface
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

    /**
     * resolve
     *
     * @return  mixed
     */
    public function resolve() {
        return $this->class;
    }
}
