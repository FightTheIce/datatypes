<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Special;

use FightTheIce\Datatypes\Core\Contracts\DatatypeInterface;
use Illuminate\Support\Traits\Macroable;

class Resource_ implements DatatypeInterface
{
    use Macroable;

    /**
     * value
     *
     * @var mixed
     */
    protected $value;

    /**
     * __construct
     *
     * @param   mixed  $res
     */
    public function __construct($res)
    {
        if (is_resource($res) == false) {
            throw new \ErrorException('X-1');
        }

        $this->value = $res;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function get_type(): string
    {
        return get_resource_type($this->value);
    }
}
