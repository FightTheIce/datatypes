<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Lists;

use Spatie\Typed\Collection;
use Spatie\Typed\T;
use FightTheIce\Datatypes\Compount\Array_;
use Illuminate\Support\Traits\Macroable;

class ListList_ extends Collection
{
    use Macroable;

    public function __construct(array $data = [])
    {
        parent::__construct(T::generic(\FightTheIce\Datatypes\Core\Contracts\ListInterface::class));
        if (empty($data) == false) {
            $this->set($data);
        }
    }
}