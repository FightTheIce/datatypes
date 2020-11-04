<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Pseudo;

use FightTheIce\Datatypes\Core\Datatype;
use FightTheIce\Datatypes\Scalar\Float_;
use FightTheIce\Datatypes\Scalar\Integer_;
use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\Support\Traits\Macroable;

class Number_ implements Datatype
{
    use Macroable {
        __call as __parentcall;
    }

    use ForwardsCalls;

    protected $number;
    protected Datatype $class;

    public function __construct($number)
    {
        $this->number = $number;

        if (!is_numeric($number)) {
            throw new \ErrorException('Only numbers are allowed.');
        }

        if (is_float($number) == true) {
            $this->class = new Float_($number);
        } elseif (is_int($number) == true) {
            $this->class = new Integer_($number);
        } else {
            throw new \ErrorException('Must be a numeric number of int, or float');
        }
    }

    public function getValue()
    {
        return $this->number;
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
