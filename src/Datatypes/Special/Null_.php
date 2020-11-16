<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Special;

use FightTheIce\Datatypes\Core\Contracts\DatatypeInterface;
use Illuminate\Support\Traits\Macroable;
use FightTheIce\Exceptions\InvalidArgumentException;

class Null_ implements DatatypeInterface
{
    use Macroable;

    /**
     * __construct.
     *
     * @param null $val
     *
     */
    public function __construct($val = null)
    {
        if (!is_null($val)) {
            $exception = new InvalidArgumentException('[NULL] is the only valid value.');
            $exception->setComponentName('datatypes');

            throw $exception;
        }
    }

    public function getValue()
    {
        return null;
    }
}
