<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Pseudo;

use FightTheIce\Datatypes\Core\Contracts\DatatypeInterface;
use FightTheIce\Datatypes\Scalar\Float_;
use FightTheIce\Datatypes\Scalar\Integer_;
use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\Support\Traits\Macroable;
use FightTheIce\Datatypes\Core\Contracts\ResolvableInterface;
use FightTheIce\Exceptions\InvalidArgumentException;

class Number_ implements DatatypeInterface, ResolvableInterface
{
    use Macroable {
        __call as __parentcall;
    }

    use ForwardsCalls;

    /**
     * number.
     *
     * @var int|float
     */
    protected $number;

    protected DatatypeInterface $class;

    /**
     * __construct.
     *
     * @param mixed $number
     *
     */
    public function __construct($number = 0)
    {
        if (!is_numeric($number)) {
            $exception = new InvalidArgumentException('Only numbers are allowed.');
            $exception->setComponentName('datatypes');
            throw $exception;
        }

        if (is_float($number + 0) == true) {
            $this->number = floatval($number);
            $this->class  = new Float_($this->number);
        } elseif (is_int($number + 0) == true) {
            $this->number = intval($number);
            $this->class  = new Integer_($this->number);
        }
    }

    public function getValue()
    {
        return $this->number;
    }

    public function getDatatypeClass(): DatatypeInterface
    {
        return $this->class;
    }

    /**
     * resolve.
     *
     * @return mixed
     */
    public function resolve()
    {
        return $this->getDatatypeClass();
    }
}
