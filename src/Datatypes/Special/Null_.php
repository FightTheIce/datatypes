<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Special;

use FightTheIce\Datatypes\Core\Contracts\DatatypeInterface;
use Illuminate\Support\Traits\Macroable;

class Null_ implements DatatypeInterface
{
    use Macroable;

    public function getValue()
    {
        return null;
    }
}
