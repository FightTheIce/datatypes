<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Lists;

use Spatie\Typed\Collection;
use Spatie\Typed\T;
use FightTheIce\Datatypes\Pseudo\Number_;
use Illuminate\Support\Traits\Macroable;

class NumberList_ extends Collection 
{
    use Macroable;
    
    public function __construct(array $data = [])
    {
        parent::__construct(T::union(T::generic(Number_::class),T::float(),T::integer()));
        if (empty($data)==false) {
            $this->set($data);
        }
    }
}