<?php
declare (strict_types = 1);

namespace FightTheIce\Datatypes\Datatype;

use FightTheIce\Datatypes\Core\Interfaces\DatatypeInterface;
use Illuminate\Support\Traits\Macroable;
use stdClass;

class stdClass_ extends stdClass implements DatatypeInterface {
    use Macroable;

    public function getType(): string {
        return 'object';
    }

    public function getValue() {
        return $this;
    }

    public function refresh() {
        return $this;
    }
}