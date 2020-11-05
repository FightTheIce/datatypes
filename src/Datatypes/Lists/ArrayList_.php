<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Lists;

use Spatie\Typed\Collection;
use Spatie\Typed\T;
use FightTheIce\Datatypes\Compounds\Array_;
use Illuminate\Support\Traits\Macroable;
use FightTheIce\Datatypes\Core\Contracts\ListInterface;

class ArrayList_ extends Collection implements ListInterface
{
    use Macroable;

    public function __construct(array $data = [])
    {
        parent::__construct(T::union(T::array(), T::generic(Array_::class)));
        if (empty($data) == false) {
            $this->set($data);
        }
    }
}
