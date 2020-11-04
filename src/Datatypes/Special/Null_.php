<?php
declare (strict_types = 1);

namespace FightTheIce\Datatypes\Special;

use FightTheIce\Datatypes\Core\Datatype;
use Illuminate\Support\Traits\Macroable;

class Null_ implements Datatype
{
    use Macroable;

    public function getValue()
    {
        return null;
    }
}
