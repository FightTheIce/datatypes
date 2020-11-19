<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Special;

use FightTheIce\Datatypes\Core\Contracts\ResourceInterface;
use Illuminate\Support\Traits\Macroable;
use Thunder\Nevar\Nevar;
use FightTheIce\Exceptions\InvalidArgumentException;
use FightTheIce\Datatypes\Core\Contracts\StringInterface;
use FightTheIce\Datatypes\Scalar\String_;

class Resource_ implements ResourceInterface
{
    use Macroable;

    /**
     * resource.
     *
     * @var mixed
     */
    protected $resource;

    /**
     * __construct.
     *
     * @param mixed $res
     */
    public function __construct($res = null)
    {
        if (is_null($res)) {
            $res = @\fopen('php://memory', 'rb');
        }

        if (!is_resource($res)) {
            $exception = new InvalidArgumentException('Parameter $res is expected to be a resource.');
            $exception->setComponentName('datatypes');

            throw $exception;
        }

        $this->resource = $res;
    }

    public function get_type(): StringInterface
    {
        return new String_(get_resource_type($this->resource));
    }

    /**
     * __toResource.
     *
     * @return mixed
     */
    public function __toResource()
    {
        return $this->resource;
    }

    public function getPrimitiveType(): string
    {
        return 'resource';
    }

    public function getDatatypeCategory(): string
    {
        return 'special';
    }

    public function describe(): string
    {
        return Nevar::describe($this->resource);
    }
}
