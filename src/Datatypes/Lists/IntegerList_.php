<?php

declare(strict_types=1);

namespace FightTheIce\Datatypes\Lists;

use Spatie\Typed\Collection;
use Spatie\Typed\T;
use FightTheIce\Datatypes\Scalar\Integer_;
use Illuminate\Support\Traits\Macroable;

class IntegerList_ extends Collection 
{
    use Macroable;
    
    public function __construct(array $data = [])
    {
        parent::__construct(T::union(T::integer(),T::generic(Integer_::class)));
        if (empty($data)==false) {
            $this->set($data);
        }
    }
}