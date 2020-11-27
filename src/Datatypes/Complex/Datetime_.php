<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Complex;

use FightTheIce\Datatypes\Core\Contracts\DatetimeInterface;
use Illuminate\Support\Traits\Macroable;
use Carbon\Carbon;
use Dont\DontGet;
use Dont\DontSet;
use FightTheIce\Datatypes\Core\Traits\PreventConstructorFromRunningTwice;

class Datetime_ extends Carbon implements DatetimeInterface
{
    use Macroable;
    use DontGet;
    use DontSet;
    use PreventConstructorFromRunningTwice;

    public function getPrimitiveType(): string
    {
        return 'string';
    }

    public function getDatatypeCategory(): string
    {
        return 'complex';
    }

    public function describe(): string
    {
        return 'datetime';
    }
}
