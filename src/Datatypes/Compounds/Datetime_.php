<?php

namespace FightTheIce\Datatypes\Compounds;

use Carbon\Carbon;
use FightTheIce\Datatypes\Core\Contracts\DatatypeInterface;

class Datetime_ extends Carbon implements DatatypeInterface
{
    public function getValue()
    {
        return $this->__toString();
    }
}
